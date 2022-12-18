<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\ExportEmployee;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\UserRole;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {   
        DB::enableQueryLog();
        $data = User::where("user_type", '3')->orderByDesc('id')->get();
        // dd(DB::getQueryLog());
        return view('admin.employee.index')->with('User', $data);
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
        return view('admin.employee.addedit');
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
            'name' => 'required|regex:/^[a-zA-Z\s]+$/|max:50',
            'email' => 'required|email|max:60|unique:users,email,' . $request->id ?? null,
            'contact' => 'required|digits:10|numeric',
            'address' => 'required|max:250',
            'status' => 'required',
            "image" => 'nullable|mimes:jpg,png,jpeg',
            'password' => 'nullable|min:6',
            'password_confirmation' => 'nullable|required_with:password|same:password',
        ]);

        $data = $request->all();
        $data['user_type'] = '3';
        $data['status'] = $request->status;
        $userdata = User::find($request->id);
        if ($request->file('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/employee_image'), $imageName);
            $data['image'] = isset($imageName) ? $imageName : null;
        } else {
            $data['image'] = isset($userdata->image) ? $userdata->image : "";
        }
        if (!$request->id) {
            $data['password'] = bcrypt($request->password);
        }
        $user = User::updateOrCreate(['id' => $request->id], $data);
        if ($request->id) {
            toastr()->success('Successfully Update User!', 'Update User');
        } else {
            UserRole::create(['role_id' => 3, 'user_id' => $user->id]);
            toastr()->success('Successfully Add User!', 'Add User');
        }
        return redirect('employee');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $User = User::where('id', $id)->first();
        return view('admin.employee.addedit')->with('User', $User);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        toastr()->success('Successfully Delete User!', 'Delete User');
        return back();
    }
    public function export(Request $request)
    {
        return Excel::download(new ExportEmployee, 'Employee-users.xlsx');
    }
}
