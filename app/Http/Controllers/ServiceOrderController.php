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
use App\Models\Pickupimage;
use Maatwebsite\Excel\Concerns\ToArray;
use SebastianBergmann\CodeCoverage\Driver\Driver;
use PDF;
use Illuminate\Support\Carbon;

class ServiceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $userType = auth()->user()->user_type;
        // if user is admin
        if ($userType == 1) {

            $data = Order::with(['Users', 'Category', 'DriverUsers', 'vehicleModel', 'Varient'])->latest()->get();
        }

        // if user is user
        if ($userType == 3) {
            $data = Order::where("user_id", auth()->user()->id)->with(['Users', 'Category', 'DriverUsers'])->latest()->get();
        }
        return view('admin.serviceorder.index')->with('Order', $data);
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
        //user_type 2 means driver
        $DriverDeail =  User::where("user_type", "2")->get();
        $vehicleModel = VehicleModel::latest()->get();
        $Location = Location::latest()->get();
        return view('admin.serviceorder.add', ["vehicleModel" => $vehicleModel, "DriverDeail" => $DriverDeail, "Location" => $Location]);
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
                'pickup_address'     => 'required|max:250',
                'drop_address'     => 'required|max:250',
                'location_id'     => 'required',
                'payment_method' => 'required',
                'invoice_date'     => 'nullable|date',
                'service_detail'     => 'nullable|max:150',
                'price'     => 'nullable|regex:/^[0-9.]+$/',
                'pick_up_time'     => 'required',
                'service_type' => 'required'
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
            $data["user_id"] =  auth()->user()->id;
        }

        //assing status add 
        //if insert records then assign_status = "1" pending 

        if (!isset($request->id)) {
            $data['assign_status'] = "1";
        }

        Order::updateOrCreate(['id' => $request->id], $data);
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
            $Order = Order::where('id', $id)->firstOrFail();
            $currentUserType = auth()->user()->user_type;
            $isEdit = false;
            if ($currentUserType == 1) {
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
                $DriverDeail = User::where("user_type", "2")->get();
                $Location = Location::latest()->get();
                return view('admin.serviceorder.add')->with('Order', $Order)->with("dropOfImages", $dropOfImages)->with("pickUpImages", $pickUpImages)->with("vehicleModel", $vehicleModel)->with('Location', $Location)->with("vehicleVarient", $vehicleVarient)->with("DriverDeail", $DriverDeail);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::find($id)->delete();

        toastr()->success('Successfully Delete Service Order!', 'Delete Service Order');
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
