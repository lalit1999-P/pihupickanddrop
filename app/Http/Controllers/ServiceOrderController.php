<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\VehicleModel;
use App\Models\VehicleVariant;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportOrder;
use App\Models\Dropoffimage;
use Exception;
use App\Models\Location;
use App\Models\ServiceInvoice;
use App\Models\Pickupimage;
use Maatwebsite\Excel\Concerns\ToArray;
use SebastianBergmann\CodeCoverage\Driver\Driver;
use PDF;
use Illuminate\Support\Carbon;
use DataTables;

class ServiceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request)
    {
        \DB::enableQueryLog(); // Enable query log

        if ($request->ajax()) {
            $userType = auth()->user()->user_type;
            // if user is admin
            if ($userType == 1) {
                $data = Order::with(['Users', 'Category', 'DriverUsers', 'vehicleModel', 'Varient']);
            } elseif ($userType == 2) {
                $userId = User::where("user_type", 3)->where('user_id', auth()->user()->id)->pluck('id')->toArray();
                array_push($userId, auth()->user()->id);
                $userIds = $userId;
                $data = Order::whereIn("user_id", $userIds)->with(['Users', 'Category', 'DriverUsers']);
            } else {
                $data = Order::where("user_id", auth()->user()->id)->with(['Users', 'Category', 'DriverUsers']);
            }
            // dump((int)$request->address_option);
            // dd($request->all());
            $startDate =  isset($request->start_date) ? date("Y-m-d", strtotime($request->start_date)) . ' 00:00:01' : null;
            $endDate =  isset($request->end_date) ? date("Y-m-d", strtotime($request->end_date)) . ' 23:59:59' : null;
            $addressOption = isset($request->address_option) ? (int)$request->address_option : 0;
            if (!empty($startDate) && !empty($endDate)) {
                $data = $data->whereBetween('created_at', [$startDate, $endDate]);
            }
            if (!empty($addressOption)) {
                $data = $data->where('address_option', $addressOption); //->toSql();
                // dump('in query');
                // dd($data);
            }

            $data = $data->latest()->get();
            //  dd($data);
            //  dd(\DB::getQueryLog()); // Show results of log

            //dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    $date = date("M d Y, h:i a", strtotime($request->created_at));
                    return $request->created_at = $date;
                })
                ->editColumn('status', function ($request) {
                    if ($request->driver_id == null) {
                        return '<span class="badge badge-primary">New Order</span>';
                    } else {
                        $name = $request->DriverUsers ? $request->DriverUsers->name : '';
                        return   '<span class="badge badge-success">' . $name . '</span>';
                    }
                })
                ->addColumn('vehicle_variant', function ($row) {
                    return $row->Varient ? $row->Varient->vehicle_variant : '';
                })
                ->addColumn('address_option', function ($row) {
                    if ($row->address_option) {
                        $addressOption = searchForAddressOption($row->address_option, getAddressOption());
                        if ($addressOption['id'] == $row->address_option) {
                            return   '<span class="badge badge-success">' . $addressOption['name'] . '</span>';
                        }
                    } else {
                        return   '<span class="badge badge-primary">No Address Option </span>';
                    }
                })
                ->addColumn('vehicle_model', function ($row) {
                    return isset($row->vehicleModel) ? $row->vehicleModel->vehicle_model : '';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $actionBtn .= '<a href="' . route('edit-serviceorder', $row->id) . '" data-id="' . $row->id . '" class="edit btn btn-info  btn-sm show_confirm"><i class="fas fa-pencil-alt"></i></a> <a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm btn-sm serviceOrderdeletebutton"><i class="fas fa-trash"></i></a>';
                    if ($row->invoice_date != null && $row->payble_amount != null) {
                        $actionBtn .= '<a href="' . route('view-invoice-serviceorder', $row->id) . '" class="btn btn-warning btn-sm"><i style="color: black" class="fas fa-file-pdf"></i></a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['created_at', 'status', 'action', 'vehicle_variant', 'vehicle_model', 'address_option'])
                ->make(true);
        }
        return view('admin.serviceorder.index');
    }

    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //user_type 4 means driver
        $DriverDeail =  User::where("user_type", 4)->get();
        $serviceAdvisory =  User::where("user_type", 5)->get();
        $vehicleModel = VehicleModel::latest()->get();
        $Location = Location::latest()->get();
        $GOOGLEAPIKEY = \Config::get('configvalue.GOOGLE_API_KEY');
        return view('admin.serviceorder.add', ["GOOGLEAPIKEY" => $GOOGLEAPIKEY, "vehicleModel" => $vehicleModel, "DriverDeail" => $DriverDeail, "serviceAdvisorys" => $serviceAdvisory, "Location" => $Location]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input());
        $request->validate(
            [
                'vehicle_model' => 'required',
                'reg_number' => 'required|max:20',
                'mobile_no'     => 'required|digits:10|numeric',
                'vehicle_variant'     => 'required',
                'full_name'     => 'required|regex:/^[a-zA-Z\s]+$/',
                // 'last_name'     => 'required|max:50|regex:/^[a-zA-Z\s]+$/',
                'email_id'     => 'required|email|email:rfc,dns',
                // 'pickup_address'     => 'required|max:250',
                //'drop_address'     => 'required|max:250',
                'location_id'     => 'required',
                //'payment_method' => 'required',
                // 'invoice_date'     => 'nullable|date',
                'service_detail'     => 'nullable|max:150',
                // 'price'     => 'nullable|regex:/^[0-9.]+$/',
                //'pick_up_time'     => 'required',
                // 'service_type' => 'required'
            ],
            [
                'price.required' => 'The Invoice Amount field is required.'
            ]
        );
        // dd($request->all());
        $data = $request->all();
        if (isset($request->user_id)) {
            $data["user_id"] =  $request->user_id;
        } else {
            $data["user_id"] = isset($request->admin_user_id) ? $request->admin_user_id : auth()->user()->id;
        }

        //assing status add 
        //if insert records then assign_status = "1" pending 

        if (!isset($request->id)) {
            $data['assign_status'] = 0;
        }
        $Order = Order::updateOrCreate(['id' => $request->id], $data);
        if (isset($request->id)) {

            $ServiceInvoiceDelete = ServiceInvoice::where('service_order_id', $request->id)->first();
            if ($ServiceInvoiceDelete) {
                ServiceInvoice::where('service_order_id', $request->id)->delete();
            }
            foreach ($request->addMoreInputFields as $key => $value) {
                $value['service_order_id'] = $Order->id;
                if (isset($value['invoice_image'])) {
                    $fileUploads = fileUpload('invoice_image', $value['invoice_image']);
                    $value['invoice_image'] = $fileUploads;
                } else {
                    $value['invoice_image'] = isset($value['old_invoice_image']) ? $value['old_invoice_image'] : null;
                }
                ServiceInvoice::create($value);
            }
            //exit;
        }
        $param = [
            "mobileList" => '917990379719',
            "message" => 'This is my first message with SMSGateway.Center'
        ];
          //   $smsGateWayResponce = smsGateWay($param);
        //  dd($smsGateWayResponce);
        if ($request->id) {
            toastr()->success('Successfully Update Service Order!', 'Update Service Order');
        } else {
            toastr()->success('Successfully Add Service Order!', 'Add Service Order');
        }
        return redirect('serviceorder');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        try {
            $Order = Order::where('id', $id)->with('ServiceInvoice')->firstOrFail();
            //  dd($Order);
            $currentUserType = auth()->user()->user_type;
            $isEdit = false;
            if ($currentUserType == 1 or $currentUserType == 2) {
                $isEdit = true;
            } else if ($currentUserType == 3) {
                if ($Order->user_id == auth()->user()->id) {
                    $isEdit = true;
                }
            }
            if ($isEdit) {
                $vehicleModel = VehicleModel::latest()->get();
                $pickUpImages = Pickupimage::where("order_id", $Order->id)->first();
                // dd($pickUpImages->image1);
                $dropOfImages = Dropoffimage::where("order_id", $Order->id)->first();
                $vehicleVarient = VehicleVariant::where("vehicle_model", $Order->vehicle_model)->get();
                // dd($vehicleVarient);
                $DriverDeail = User::where("user_type", 4)->get();
                $Location = Location::latest()->get();
                $ServiceInvoice = ServiceInvoice::where('service_order_id', $Order->id)->get();
                $serviceAdvisory =  User::where("user_type", 5)->get();
                $GOOGLEAPIKEY = \Config::get('configvalue.GOOGLE_API_KEY');

                return view('admin.serviceorder.add')->with("GOOGLEAPIKEY", $GOOGLEAPIKEY)->with('Order', $Order)->with("serviceAdvisorys", $serviceAdvisory)->with("ServiceInvoice", $ServiceInvoice)->with("dropOfImages", $dropOfImages)->with("pickUpImages", $pickUpImages)->with("vehicleModel", $vehicleModel)->with('Location', $Location)->with("vehicleVarient", $vehicleVarient)->with("DriverDeail", $DriverDeail);
            } else {
                toastr()->error('You have no permission! Edit', 'No - Permission');
                return to_route("serviceorder");
            }
        } catch (Exception $th) {
            toastr()->error('Something is wrong', 'Something is wrong');
            return to_route("serviceorder");
        }
    }

    public function viewinvoice($id)
    {
        $data = Order::with(['Users', 'DriverUsers', "Varient", "vehicleModel", "location"])->where('id', $id)->first();
        //  dd($data);
        return view('admin.serviceorder.view-invoice')->with('invoicedata', $data);
    }

    public function invoiceImageUpload(Request $request)
    {
        return fileUpload('invoice_image', $request->file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Order::find($request->id)->delete();

        // toastr()->success('Successfully Delete Service Order!', 'Delete Service Order');
        return back();
    }
    public function export(Request $request)
    {
        return Excel::download(new ExportOrder, 'service-order.xlsx');
    }
    public function generateInvoicePDF(Request $request, $id)
    {
        $data = Order::with(['Users', 'DriverUsers', "Varient", "vehicleModel", "location"])->where('id', $id)->first()->ToArray();
        // dd($data);
        $pdf = PDF::loadView('admin.serviceorder.myPDF', $data);
        return $pdf->download('invoice.pdf');
    }
    public function saveinvoice(Request $request)
    {
        $Order = Order::find($request->invoiceId);
        $Order->invoice_date = Carbon::parse($request->invoice_date)->format('y/m/d');
        $Order->price = $request->price;
        $Order->save();

        toastr()->success('Successfully Update Invoice!', 'Invoice');
        return back();
    }
}
