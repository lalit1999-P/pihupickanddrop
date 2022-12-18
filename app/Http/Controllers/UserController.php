<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportUser;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Svg\Tag\Rect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $data = User::orderByDesc('id')->where('user_type', 2)->with('UserDetails')->latest()->get();
        return view('admin.user.index')->with('User', $data);
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
        return view('admin.user.addedit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            'name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email',
            'contact' => 'required|numeric|digits:10|unique:users,contact,' . $request->id ?? null,
            'age' => 'required',
            'dob' => 'required',
            'status' => 'required',
            'blood_group' => 'required',
            'gender' => 'required',
            'address' => 'required|max:500',
            'password' => 'nullable',
            'password_confirmation' => 'nullable|required_with:password|same:password',
            'pan' => 'required|max:10|min:10',
            'adhaar' => 'required|min:12|max:12',
            'account_holder_name' => 'nullable|regex:/^[a-zA-Z\s]+$/',
            'account_no' => 'nullable',
            'isfc_code' => 'nullable',
            'pan_image' => 'nullable|mimes:png,jpeg,jpg',
            'adhaar_image' => 'nullable|mimes:png,jpeg,jpg',
            'licence_image' => 'nullable|mimes:png,jpeg,jpg',
            'account_details_image' => 'nullable|mimes:png,jpeg,jpg',
            'police_vf_image' => 'nullable|mimes:png,jpeg,jpg',

        ];

        if (!$request->id) {
            $rule['resume'] = 'required|mimes:jpg,jpeg,png,pdf,docx,application/pdf,doc';
        }
        $msg = [
            'pan.required' => 'The pancard field is required.',
            'pan.max' => 'The pancard number must not be greater than 10 digit.',
            'pan.pan' => 'The pancard number must be at least 10 digit.',
            'adhaar.required' => 'The adhaar card field is required.',
            'adhaar.max' => 'The adhaar card number must not be greater than 12 digit.',
            'adhaar.min' => 'The adhaar card number must be at least 12 digit.',
            'resume.mimes' => 'please upload only jpg,jpeg,png,pdf,doc file'
        ];

        $validation  = Validator::make($request->all(), $rule, $msg);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }

        $data = $request->all();
        $data['user_type'] = 2;
        $data['status'] = $request->status;
        $userdata = User::find($request->id);
        if ($request->file('image')) {
            $data['image'] = fileUpload('driver_image', $request->image);
        } else {
            $data['image'] = $userdata->image ?? "";
        }
        if (!$request->id) {
            $data['password'] = bcrypt($request->password);
        }
        $user = User::updateOrCreate(['id' => $request->id], $data);
        $userdetails = UserDetails::where('user_id', $request->id)->first();
        $data['user_id'] = isset($user->id) ? $user->id : $request->id;
        if ($request->file('pan_image')) {
            $data['pan_image'] = fileUpload('driver_image', $request->pan_image);
        } else {
            $data['pan_image'] = isset($userdetails->pan_image) ? $userdetails->pan_image : null;
        }
        if ($request->file('adhaar_image')) {
            $data['adhaar_image'] = fileUpload('driver_image', $request->adhaar_image);
        } else {
            $data['adhaar_image'] = isset($userdetails->adhaar_image) ? $userdetails->adhaar_image : null;
        }
        if ($request->file('licence_image')) {
            $data['licence_image'] = fileUpload('driver_image', $request->licence_image);
        } else {
            $data['licence_image'] = isset($userdetails->licence_image) ? $userdetails->licence_image : null;
        }
        if ($request->file('account_details_image')) {
            $data['account_details_image'] = fileUpload('driver_image', $request->account_details_image);
        } else {
            $data['account_details_image'] = isset($userdetails->account_details_image) ? $userdetails->account_details_image : null;
        }
        if ($request->file('police_vf_image')) {
            $data['police_vf_image'] = fileUpload('driver_image', $request->police_vf_image);
        } else {
            $data['police_vf_image'] = isset($userdetails->police_vf_image) ? $userdetails->police_vf_image : null;
        }
        if ($request->file('resume')) {
            // dd("hiii hardik");
            $data['resume'] = fileUpload('driver_image', $request->resume);
        } else {
            $data['resume'] = isset($userdetails->resume) ? $userdetails->resume : null;
        }

        UserDetails::updateOrCreate(['user_id' => $user->id], $data);

        if ($request->id) {
            toastr()->success('Successfully Update Driver User!', 'Update Driver User');
        } else {
            toastr()->success('Successfully Add Driver User!', 'Add Driver User');
        }
        return redirect('users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $User = User::where('id', $id)->with('UserDetails')->first();
        return view('admin.user.addedit')->with('User', $User);
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

        toastr()->success('Successfully Delete Driver User!', 'Delete Driver User');
        return back();
    }
    public function exportUsers(Request $request)
    {
        return Excel::download(new ExportUser, 'Driver-users.xlsx');
    }
    public function changePassword($id)
    {

        return view('admin.user.password', ['id' => $id]);
    }
    public function updatePassword(Request $request)
    {
        // dd($us);
        $rule = [
            'password' => 'required',
            'password_confirmation' => 'required|required_with:password|same:password',
            'id' => 'required',
        ];

        $validation  = Validator::make($request->all(), $rule);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }

        try {
            $userData = User::where('id', $request->id)->firstOrFail();
            $userData->password = bcrypt($request->password);
            $userData->save();
            toastr()->success('Successfully Update Password!', 'Update Password');
            return to_route('user');
        } catch (Exception $e) {
            toastr()->error('$e->getMessage() ', 'Something Is Wrong');
            return to_route('user');
        }
    }
}
