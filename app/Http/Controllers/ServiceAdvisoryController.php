<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\ExportEmployee;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\UserRole;

class ServiceAdvisoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        DB::enableQueryLog();
        if (auth()->user()->id == 1) {
            $data = User::where("user_type", 5)->orderByDesc('id')->get();
        } else {
            $data = User::where("user_type", 5)->where('user_id', auth()->user()->id)->orderByDesc('id')->get();
        }
        // dd(DB::getQueryLog());
        return view('admin.serviceadvisory.index')->with('User', $data);
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
        return view('admin.serviceadvisory.addedit');
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
            //'password' => 'nullable|min:6',
            //'password_confirmation' => 'nullable|required_with:password|same:password',
        ]);

        $data = $request->all();
        $data['user_type'] = 5;
        $data['status'] = $request->status;
        $userdata = User::find($request->id);
        if ($request->file('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/serviceadvisory'), $imageName);
            $data['image'] = isset($imageName) ? $imageName : null;
        } else {
            $data['image'] = isset($userdata->image) ? $userdata->image : "";
        }
        if (!$request->id) {
            $data['user_id'] = isset($request->admin_user_id) ? $request->admin_user_id : auth()->user()->id;
            $data['password'] = bcrypt(123456);
        } else {
            if (auth()->user()->id == 1) {
                $data['user_id'] = isset($request->admin_user_id) ? $request->admin_user_id : auth()->user()->id;
            }
        }
        $user = User::updateOrCreate(['id' => $request->id], $data);
        if ($request->id) {
            toastr()->success('Successfully Update Service Advisory!', 'Update Service Advisory');
        } else {
            UserRole::create(['role_id' => 5, 'user_id' => $user->id]);
            toastr()->success('Successfully Add Service Advisory!', 'Add Service Advisory');
        }
        return redirect('service-advisory');
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
        return view('admin.serviceadvisory.addedit')->with('User', $User);
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

        toastr()->success('Successfully Delete Service Advisory!', 'Delete Service Advisory');
        return back();
    }
    public function export(Request $request)
    {
        return Excel::download(new ExportEmployee, 'Service-Advisory.xlsx');
    }
}
