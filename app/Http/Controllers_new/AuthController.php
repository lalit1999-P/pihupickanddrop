<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use toster;
use App\Models\User;
use App\Rules\MatchOldPassword;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            toastr()->success(' you have Signed in successfully !', 'Signed in');
            return redirect('/');
        }
        toastr()->error('Login details are not valid.', 'Login failed');
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profileView($id)
    {
        $User = User::find($id);
        return view('auth.profile')->with('User', $User);
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
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'oldpassword' => ['nullable', new MatchOldPassword],

        ]);
        $data = $request->all();
        // $data['user_type'] = 4;
        // $data['status'] = 1;
        $userdata = User::find($request->id);
        if ($request->file('image')) {
            $data['image'] = fileUpload('employee_image', $request->image);;
        } else {
            $data['image'] = $userdata->image;
        }
        if ($request->newpassword) {
            $data['password'] = bcrypt($request->newpassword);
        }
        User::updateOrCreate(['id' => $request->id], $data);
        toastr()->success('Successfully Profile Updated!', 'Update Profile');
        return redirect('/');
    }

    public function viewForgotPassword(Request $request)
    {
        return view('auth.forgot-password');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'newpassword' => 'min:6',
            'confirmpassword' => 'required_with:newpassword|same:newpassword|min:6'
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = bcrypt($request->newpassword);
            $user->save();
            toastr()->success('Successfully Forgot Password!', 'Forgot Password');
            return redirect('login');
        } else {
            toastr()->error('Email is Not Found Please check Email!', 'Worg Email');
            return back();
        }
    }
}
