<?php

namespace App\Http\Controllers;

use App\Models\VehicleModel;
use Illuminate\Http\Request;
use App\Models\VehicleVariant;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportVehicleModel;
class VehicleModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $data = VehicleModel::latest()->get();
        return view('admin.vehiclemodel.index')->with('vehiclemodel', $data);
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
        return view('admin.vehiclemodel.addedit')->with('VehicleModelData', $VehicleModel);
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
            'vehicle_model' => 'required|max:50',
        ]);

        $data = $request->all();
        VehicleModel::updateOrCreate(['id' => $request->id], $data);
        if ($request->id) {
            toastr()->success('Successfully Update Vehicle Model!', 'Update Vehicle Model');
        } else {
            toastr()->success('Successfully Add Vehicle Model!', 'Add Vehicle Model');
        }
        return redirect('vehicle-model');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $VehicleModel = VehicleModel::all();
        $VehicleModel = VehicleModel::where('id', $id)->first();
        return view('admin.vehiclemodel.addedit')->with('VehicleModel', $VehicleModel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        VehicleModel::find($id)->delete();

        toastr()->success('Successfully Delete Vehicle Model!', 'Delete Vehicle Model');
        return back();
    }
    public function export(Request $request)
    {
        return Excel::download(new ExportVehicleModel, 'vehicle-model.xlsx');
    }
}
