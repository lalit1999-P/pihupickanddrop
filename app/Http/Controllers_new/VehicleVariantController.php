<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleVariant;
use App\Models\VehicleModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportVehicleVariant;
class VehicleVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $data = VehicleVariant::latest()->get();
        return view('admin.vehiclevariant.index')->with('vehiclevariant', $data);
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
        $VehicleModel = VehicleModel::all();
        return view('admin.vehiclevariant.addedit')->with('VehicleModel', $VehicleModel);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_model' => 'required',
            'vehicle_variant' => 'required|max:50',
        ]);

        $data = $request->all();
        VehicleVariant::updateOrCreate(['id' => $request->id], $data);
        if ($request->id) {
            toastr()->success('Successfully Update Vehicle Variant!', 'Update Vehicle Variant');
        } else {
            toastr()->success('Successfully Add Vehicle Variant!', 'Add Vehicle Variant');
        }
        return redirect('vehicle-variant');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $VehicleModel = VehicleModel::all();
        $VehicleVariant = VehicleVariant::where('id', $id)->first();
        return view('admin.vehiclevariant.addedit')->with('VehicleModel', $VehicleModel)->with('VehicleVariant', $VehicleVariant);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        VehicleVariant::find($id)->delete();

        toastr()->success('Successfully Delete Vehicle Variant!', 'Delete Vehicle Variant');
        return back();
    }

    public function getVehicleVarient(Request $request)
    {
        $VehicleVariant = VehicleVariant::select("vehicle_variant", "id")->where("vehicle_model", $request->varient_id)->get();
        return $VehicleVariant;
    }
    public function export(Request $request)
    {
        return Excel::download(new ExportVehicleVariant, 'vehicle-variant.xlsx');
    }
}
