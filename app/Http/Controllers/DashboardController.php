<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\VehicleModel;
use App\Models\VehicleVariant;
use App\Models\Order;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if (auth()->user()->user_type == 1) {
            $data['Category'] = Category::count();
            $data['SubCategory'] = SubCategory::count();
            $data['EmployeeUser'] = User::where('user_type', 3)->count();
            $data['VehicleModel'] = VehicleModel::count();
            $data['VehicleVariant'] = VehicleVariant::count();
            $data['DriverUsers'] = User::where('user_type', 4)->count();
            $data['AdminUsers'] = User::where('user_type', 2)->count();
            $data['Order'] =  Order::count();
            $data['OrderDetails'] =  Order::latest('id')->limit(5)->get();
        } else {
            $data['Category'] = Category::count();
            $data['SubCategory'] = SubCategory::count();
            $data['EmployeeUser'] = User::where('user_type', 3)->where("user_id", auth()->user()->id)->count();
            $data['VehicleModel'] = VehicleModel::count();
            $data['VehicleVariant'] = VehicleVariant::count();
            $data['DriverUsers'] = User::where('user_type', 4)->where("user_id", auth()->user()->id)->count();
            $data['AdminUsers'] = User::where('user_type', 2)->count();
            if (auth()->user()->user_type == 3) {
                $data['Order'] =  Order::where("user_id", auth()->user()->id)->count();
                $data['OrderDetails'] =  Order::where("user_id", auth()->user()->id)->latest('id')->limit(5)->get();
            } else {
                $userId = User::where("user_type", 3)->where('user_id', auth()->user()->id)->pluck('id')->toArray();
                array_push($userId, auth()->user()->id);
                $userIds = $userId;
              //  dd($userIds);
                $data['Order'] = Order::whereIn("user_id", $userIds)->with(['Users', 'Category', 'DriverUsers'])->latest()->count();
                $data['OrderDetails'] =  Order::whereIn("user_id", $userIds)->with(['Users', 'Category', 'DriverUsers'])->latest('id')->limit(5)->get();
            }
        }
        return view('admin.dashbord')->with('TotalCount', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
