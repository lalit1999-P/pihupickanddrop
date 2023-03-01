<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Str;
use DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $data = User::where("user_type", 2)->get();
        return view('admin.admin.index')->with('admin', $data);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where("user_type", 2)->get();
            $startDate =  isset($request->start_date) ? date("Y-m-d", strtotime($request->start_date)) . ' 00:00:01' : null;
            $endDate =  isset($request->end_date) ? date("Y-m-d", strtotime($request->end_date)) . ' 23:59:59' : null;

            if (!empty($startDate) && !empty($endDate)) {
                $data = $data->whereBetween('created_at', [$startDate, $endDate]);
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    $date = date("M d Y, h:i a", strtotime($request->created_at));
                    return $request->created_at = $date;
                })
                ->editColumn('status', function ($request) {
                    if ($request->status == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return   '<span class="badge badge-danger">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('edit-admin', $row->id) . '" data-id="' . $row->id . '" class="edit btn btn-info  btn-sm"><i class="fas fa-pencil-alt"></i></a> <a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm btn-sm admindeletebutton"><i class="fas fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['created_at', 'status', 'action'])
                ->make(true);
        }
        return view('admin.admin.index');
    }

    public function create()
    {
        return view('admin.admin.addedit');
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
        $data['user_type'] = 2;
        $data['status'] = $request->status;
        $userdata = User::find($request->id);
        if ($request->file('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/admin_image'), $imageName);
            $data['image'] = isset($imageName) ? $imageName : null;
        } else {
            $data['image'] = isset($userdata->image) ? $userdata->image : "";
        }
        if (!$request->id) {
            $data['user_id'] = auth()->user()->id;
            $data['password'] = bcrypt($request->password);
        }
        $user = User::updateOrCreate(['id' => $request->id], $data);
        if ($request->id) {
            toastr()->success('Successfully Update User!', 'Update User');
        } else {
            UserRole::create(['role_id' => 2, 'user_id' => $user->id]);
            toastr()->success('Successfully Add User!', 'Add User');
        }
        return redirect('admin');
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
        return view('admin.admin.addedit')->with('User', $User);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::find($request->id)->delete();

        toastr()->success('Successfully Delete User!', 'Delete User');
        return back();
    }
    public function export(Request $request)
    {
        //return Excel::download(new ExportEmployee, 'Employee-users.xlsx');
    }
}
