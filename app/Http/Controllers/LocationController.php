<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->id == 1) {
            $data = Location::orderByDesc('id')->get();
        } else {
            $data = Location::where('user_id', auth()->user()->id)->orderByDesc('id')->get();
        }
        return view('admin.location.index')->with('Location', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.location.addedit');
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
            'location' => 'required|max:80',
            'address' => 'required|max:250',
            'status' => 'required'
        ]);

        $data = $request->all();
        if (!$request->id) {
            $data['user_id'] = isset($request->admin_user_id) ? $request->admin_user_id : auth()->user()->id;
        } else {
            if (auth()->user()->id == 1) {
                $data['user_id'] = isset($request->admin_user_id) ? $request->admin_user_id : auth()->user()->id;
            }
        }
        Location::updateOrCreate(['id' => $request->id], $data);
        if ($request->id) {
            toastr()->success('Successfully Update Location!', 'Update Location');
        } else {
            toastr()->success('Successfully Add Location!', 'Add Location');
        }
        return redirect('location');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Location = Location::where('id', $id)->first();
        return view('admin.location.addedit')->with('Location', $Location);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Location::find($id)->delete();

        toastr()->success('Successfully Delete Location!', 'Delete Location');
        return back();
    }
    // public function export(Request $request)
    // {
    //     return Excel::download(new ExportEmployee, 'Employee-users.xlsx');
    // }
}
