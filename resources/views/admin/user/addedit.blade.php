@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">{{ isset($User->id) ? 'Driver User Update' : 'Driver User Add' }}</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user') }}">Driver Users</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ isset($User->id) ? 'Driver User Update' : 'Driver User Add' }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-6 col-4 align-self-center">
                <div class="text-end upgrade-btn">

                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- column -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('store-users') }}" method="POST" enctype="multipart/form-data">

                            @csrf
                            <input type="hidden" name="id" value="{{ isset($User) ? $User->id : null }}">
                            <div class="pl-lg-4">
                                <h6 class="heading-small text-muted mb-4">User information</h6>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Full Name
                                                {!! fieldRequired() !!}</label>
                                            <input type="text" id="input-username" class="form-control" name="name"
                                                placeholder="Username"
                                                value="{{ isset($User) ? $User->name : old('name') }}">
                                            @if ($errors->has('name'))
                                                <span class="alert-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Mobile
                                                Number {!! fieldRequired() !!}</label>
                                            <input type="number" id="input-username" class="form-control"
                                                placeholder="Mobile Number" name="contact"
                                                value="{{ isset($User) ? $User->contact : old('contact') }}">
                                            @if ($errors->has('contact'))
                                                <span class="alert-danger">{{ $errors->first('contact') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Email
                                                {!! fieldRequired() !!}</label>
                                            <input type="email" id="input-username" class="form-control"
                                                placeholder="Email"
                                                value="{{ isset($User) ? $User->email : old('email') }}" name="email">
                                            @if ($errors->has('email'))
                                                <span class="alert-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="margin-top: 10px" class="form-control-label">
                                                Gender {!! fieldRequired() !!}
                                            </label>
                                            <br>
                                            <div>
                                                @if (old('gender'))
                                                    <input type="radio" id="male"
                                                        {{ old('gender') == 'Male' ? 'checked' : '' }} name="gender"
                                                        value="Male">
                                                    <label for="male">Male</label>
                                                    <input type="radio" id="female"
                                                        {{ old('gender') == 'Female' ? 'checked' : '' }} name="gender"
                                                        value="Female">
                                                    <label for="female">Female</label>
                                                @else
                                                    <input type="radio" id="male"
                                                        {{ isset($User->UserDetails->gender) ? 'checked="checked"' : '' }}
                                                        name="gender" value="Male">
                                                    <label for="male">Male</label>
                                                    <input type="radio" id="female"
                                                        {{ isset($User->UserDetails->gender) ? 'checked="checked"' : '' }}
                                                        name="gender" value="Female">
                                                    <label for="female">Female</label>
                                                @endif

                                            </div>

                                            @if ($errors->has('gender'))
                                                <span class="alert-danger">{{ $errors->first('gender') }}</span>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="inputClientCompany">Address {!! fieldRequired() !!} </label>
                                            <textarea id="address" name="address" focus style="height:150px" class="form-control">{{ (isset($User) ? $User->name : isset($User)) ? $User->address : old('address') }}</textarea>
                                            @if ($errors->has('address'))
                                                <span class="alert-danger">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-dob">Date of Birth
                                                {!! fieldRequired() !!} </label>
                                            <input type="date" id="input-dob" class="form-control year_count"
                                                placeholder="dob" max="<?php echo date('Y-m-d'); ?>"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->dob : old('dob') }}"
                                                name="dob">
                                            @if ($errors->has('dob'))
                                                <span class="alert-danger">{{ $errors->first('dob') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-age">Age
                                                {!! fieldRequired() !!}</label>
                                            <input type="number" id="input-age" class="form-control" placeholder="age"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->age : old('age') }}"
                                                name="age">
                                            @if ($errors->has('age'))
                                                <span class="alert-danger">{{ $errors->first('age') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username"> Status
                                                {!! fieldRequired() !!} </label>
                                            <select class="form-control" name="status" id="status">
                                                @if (old('status'))
                                                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>
                                                        Active </option>
                                                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>
                                                        Inactive </option>
                                                @else
                                                    <option value="1"
                                                        {{ isset($User->status) ? ($User->status == '1' ? 'selected' : '') : '' }}>
                                                        Active </option>
                                                    <option value="0"
                                                        {{ isset($User->status) ? ($User->status == '0' ? 'selected' : '') : '' }}>
                                                        Inactive </option>
                                                @endif
                                            </select>
                                            @if ($errors->has('status'))
                                                <span class="alert-danger">{{ $errors->first('status') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    @if (!isset($User))
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="password_user">Password
                                                    {!! fieldRequired() !!}</label>

                                                <div class="input-group">
                                                    <input type="password" id="password_user" class="form-control "
                                                        placeholder="Password" value="{{ old('password') ?? '' }}"
                                                        name="password">
                                                    <div class="input-group-append show_password">
                                                        <div class="input-group-text">
                                                            <span class="fa fa-fw field-icon  fa-eye-slash"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($errors->has('password'))
                                                    <span class="alert-danger">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="password_confirmation">Confirm
                                                    Password {!! fieldRequired() !!}</label>

                                                <div class="input-group">
                                                    <input type="password" id="password_confirmation"
                                                        class="form-control " placeholder="Confirm Password"
                                                        value="{{ old('password_confirmation') ?? '' }}"
                                                        name="password_confirmation">
                                                    <div class="input-group-append show_password">
                                                        <div class="input-group-text">
                                                            <span class="fa fa-eye-slash"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($errors->has('password_confirmation'))
                                                    <span
                                                        class="alert-danger">{{ $errors->first('password_confirmation') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="pan-card">Pan Card Number
                                                {!! fieldRequired() !!}</label>
                                            <input id="pan-card" class="form-control" placeholder="Pan Card Number"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->pan : old('pan') }}"
                                                type="text" name="pan">
                                            @if ($errors->has('pan'))
                                                <span class="alert-danger">{{ $errors->first('pan') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">
                                                Pan Card Image
                                            </label>
                                            <input type="file" accept="image/*" class="form-control" name="pan_image"
                                                id="customFileLang" lang="en">
                                            @if ($errors->has('pan_image'))
                                                <span class="alert-danger">{{ $errors->first('pan_image') }}</span>
                                            @endif
                                            @if (isset($User->UserDetails))
                                                @if ($User->UserDetails->pan_image &&
                                                    file_exists(public_path('images/driver_image/' . $User->UserDetails->pan_image)))
                                                    <img src="{{ asset('images/driver_image') . '/' . $User->UserDetails->pan_image }}"
                                                        alt="Image" class="brand-image"
                                                        style="width:100px;hieght:100px">
                                                    {{-- @else
                                                        <img src="{{ asset('images/no-image-icon-6.png') }}" alt="Image"
                                                            class="brand-image" style="width:100px;hieght:100px"> --}}
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Aadhaar Card
                                                Number {!! fieldRequired() !!}</label>
                                            <input id="input-address" class="form-control"
                                                placeholder="Aadhaar Card Number"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->adhaar : old('adhaar') }}"
                                                type="number" name="adhaar">
                                            @if ($errors->has('adhaar'))
                                                <span class="alert-danger">{{ $errors->first('adhaar') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">
                                                Adhaar Image
                                            </label>
                                            <input type="file" accept="image/*" class="form-control"
                                                name="adhaar_image" id="customFileLang" lang="en">
                                            @if ($errors->has('adhaar_image'))
                                                <span class="alert-danger">{{ $errors->first('adhaar_image') }}</span>
                                            @endif
                                            @if (isset($User->UserDetails))
                                                @if (isset($User->UserDetails->adhaar_image) &&
                                                    file_exists(public_path('images/driver_image/' . $User->UserDetails->adhaar_image)))
                                                    <img src="{{ asset('images/driver_image') . '/' . $User->UserDetails->adhaar_image }}"
                                                        alt="Image" class="brand-image"
                                                        style="width:100px;hieght:100px">
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">
                                                Profile Image
                                            </label>
                                            <input type="file" accept="image/*" accept="image/*" class="form-control"
                                                name="image" id="customFileLang" lang="en">
                                            @if ($errors->has('image'))
                                                <span class="alert-danger">{{ $errors->first('image') }}</span>
                                            @endif
                                            @if (isset($User))
                                                @if ($User->image && file_exists(public_path('images/driver_image/' . $User->image)))
                                                    <img src="{{ asset('images/driver_image') . '/' . $User->image }}"
                                                        alt="Image" class="brand-image"
                                                        style="width:100px;hieght:100px">
                                                @endif
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username"> Blood Group
                                                {!! fieldRequired() !!} </label>
                                            <select class="form-control select2" name="blood_group" id="blood_group">
                                                <option value=" ">Select Blood Group </option>
                                                @if (old('blood_group'))
                                                    <option value="O+"
                                                        {{ old('blood_group') == 'O+' ? 'selected' : '' }}>
                                                        O+ </option>
                                                    <option value="O-"
                                                        {{ old('blood_group') == 'O-' ? 'selected' : '' }}>
                                                        O- </option>
                                                    <option value="A+"
                                                        {{ old('blood_group') == 'A+' ? 'selected' : '' }}>
                                                        A+ </option>
                                                    <option value="A+"
                                                        {{ old('blood_group') == 'A+' ? 'selected' : '' }}>
                                                        A- </option>
                                                    <option value="B+"
                                                        {{ old('blood_group') == 'B+' ? 'selected' : '' }}>
                                                        B+ </option>
                                                    <option value="B-"
                                                        {{ old('blood_group') == 'B-' ? 'selected' : '' }}>
                                                        B- </option>
                                                    <option value="AB+"
                                                        {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>
                                                        AB+ </option>
                                                    <option value="AB-"
                                                        {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>
                                                        AB- </option>
                                                @else
                                                    <option value="O+"
                                                        {{ isset($User->UserDetails) ? ($User->UserDetails->blood_group == 'O+' ? 'selected' : '') : '' }}>
                                                        O+ </option>
                                                    <option value="O-"
                                                        {{ isset($User->UserDetails) ? ($User->UserDetails->blood_group == 'O-' ? 'selected' : '') : '' }}>
                                                        O- </option>
                                                    <option value="A+"
                                                        {{ isset($User->UserDetails) ? ($User->UserDetails->blood_group == 'A+' ? 'selected' : '') : '' }}>
                                                        A+ </option>
                                                    <option value="A+"
                                                        {{ isset($User->UserDetails) ? ($User->UserDetails->blood_group == 'A-' ? 'selected' : '') : '' }}>
                                                        A- </option>
                                                    <option value="B+"
                                                        {{ isset($User->UserDetails) ? ($User->UserDetails->blood_group == 'B+' ? 'selected' : '') : '' }}>
                                                        B+ </option>
                                                    <option value="B-"
                                                        {{ isset($User->UserDetails) ? ($User->UserDetails->blood_group == 'B-' ? 'selected' : '') : '' }}>
                                                        B- </option>
                                                    <option value="AB+"
                                                        {{ isset($User->UserDetails) ? ($User->UserDetails->blood_group == 'AB+' ? 'selected' : '') : '' }}>
                                                        AB+ </option>
                                                    <option value="AB-"
                                                        {{ isset($User->UserDetails) ? ($User->UserDetails->blood_group == 'AB-' ? 'selected' : '') : '' }}>
                                                        AB- </option>
                                                @endif

                                            </select>
                                            @if ($errors->has('blood_group'))
                                                <span class="alert-danger">{{ $errors->first('blood_group') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if (auth()->user()->user_type == 1)
                                                <div class="form-group">
                                                    <label>Admin User List</label>
                                                    <select class="form-control select2" name="admin_user_id"
                                                        style="width: 100%;">
                                                        <option value="">-Select Admin-</option>
                                                        @foreach (getAdminList() as $adminUser)
                                                            @if (old('admin_user_id'))
                                                                <option value="{{ $adminUser->id }}"
                                                                    {{ old('adminUser') == $adminUser->id ? 'selected' : "'" }}>
                                                                    {{ $adminUser->name }}
                                                                </option>
                                                            @else
                                                                <?php $idAdminUser = isset($User) ? $User->user_id : null; ?>
                                                                <option value="{{ $adminUser->id }}"
                                                                    @if ($adminUser->id == $idAdminUser) selected @endif>
                                                                    {{ $adminUser->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('admin_user_id'))
                                                        <span
                                                            class="alert-danger">{{ $errors->first('admin_user_id') }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                            </div>
                            {{-- <hr class="my-4" /> --}}
                            <!-- Description -->
                            {{-- <h6 class="heading-small text-muted mb-4">About user</h6> --}}

                            <hr class="my-4" />
                            <h6 class="heading-small text-muted mb-4">Driving Detail</h6>
                            <div class="pl-lg-4">

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="licence_no">Licence
                                                Number</label>
                                            <input id="licence_no" class="form-control" name="licence_no"
                                                placeholder="Licence Number"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->licence_no : old('licence_no') }}"
                                                type="text" name="licence_no">
                                            @if ($errors->has('licence_no'))
                                                <span class="alert-danger">{{ $errors->first('licence_no') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">
                                                Licence
                                            </label>
                                            <input type="file" accept="image/*" class="form-control"
                                                name="licence_image" id="customFileLang" lang="en">
                                            @if ($errors->has('licence_image'))
                                                <span class="alert-danger">{{ $errors->first('licence_image') }}</span>
                                            @endif
                                            @if (isset($User->UserDetails))
                                                @if ($User->UserDetails->licence_image &&
                                                    file_exists(public_path('images/driver_image/' . $User->UserDetails->licence_image)))
                                                    <img src="{{ asset('images/driver_image') . '/' . $User->UserDetails->licence_image }}"
                                                        alt="Image" class="brand-image"
                                                        style="width:100px;hieght:100px">
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">
                                                Police Verification Image
                                            </label>
                                            <input type="file" accept="image/*" class="form-control"
                                                name="police_vf_image" id="police_vf_image">
                                            @if ($errors->has('police_vf_image'))
                                                <span class="alert-danger">{{ $errors->first('police_vf_image') }}</span>
                                            @endif
                                            @if (isset($User->UserDetails))
                                                @if ($User->UserDetails->police_vf_image &&
                                                    file_exists(public_path('images/driver_image/' . $User->UserDetails->police_vf_image)))
                                                    <img src="{{ asset('images/driver_image') . '/' . $User->UserDetails->police_vf_image }}"
                                                        alt="Image" class="brand-image"
                                                        style="width:100px;hieght:100px">
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Driving
                                                Experience</label>
                                            <input id="input-address" class="form-control"
                                                placeholder="Driving Experience"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->driving_experience : old('driving_experience') }}"
                                                type="text" name="driving_experience">
                                            @if ($errors->has('driving_experience'))
                                                <span
                                                    class="alert-danger">{{ $errors->first('driving_experience') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                            {{-- account detail --}}
                            <hr class="my-4" />
                            <h6 class="heading-small text-muted mb-4">Bank Account Details</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="account_holder_name">Account Holder
                                                Name
                                            </label>
                                            <input id="account_holder_name" class="form-control"
                                                name="account_holder_name" placeholder="Account Holder Name"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->account_holder_name : old('account_holder_name') }}"
                                                type="text" name="account_holder_name">
                                            @if ($errors->has('account_holder_name'))
                                                <span
                                                    class="alert-danger">{{ $errors->first('account_holder_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="account_no">Account Number
                                            </label>
                                            <input id="account_no" class="form-control" name="account_no"
                                                placeholder="Account Number"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->account_no : old('account_no') }}"
                                                type="text" name="account_no">
                                            @if ($errors->has('account_no'))
                                                <span class="alert-danger">{{ $errors->first('account_no') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="isfc_code">ISFC Code
                                            </label>
                                            <input id="isfc_code" class="form-control" name="isfc_code"
                                                placeholder="ISFC Code"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->isfc_code : old('isfc_code') }}"
                                                type="text" name="isfc_code">
                                            @if ($errors->has('isfc_code'))
                                                <span class="alert-danger">{{ $errors->first('isfc_code') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="bank_name">Bank Name
                                            </label>
                                            <input id="bank_name" class="form-control" name="bank_name"
                                                placeholder="Bank Name"
                                                value="{{ isset($User->UserDetails->bank_name) ? $User->UserDetails->bank_name : old('bank_name') }}"
                                                type="text" name="bank_name">
                                            @if ($errors->has('bank_name'))
                                                <span class="alert-danger">{{ $errors->first('bank_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">
                                                Account Details Image
                                            </label>
                                            <input type="file" accept="image/*" class="form-control"
                                                name="account_details_image" id="customFileLang" lang="en">
                                            @if ($errors->has('account_details_image'))
                                                <span
                                                    class="alert-danger">{{ $errors->first('account_details_image') }}</span>
                                            @endif
                                            @if (isset($User->UserDetails))
                                                @if ($User->UserDetails->account_details_image && file_exists(public_path('images/driver_image/' . $User->UserDetails->account_details_image)))
                                                    <img src="{{ asset('images/driver_image') . '/' . $User->UserDetails->account_details_image }}"
                                                        alt="Image" class="brand-image"
                                                        style="width:100px;hieght:100px">
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <hr class="my-4" />
                            <!-- Description -->
                            <h6 class="heading-small text-muted mb-4">Family Details</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Wife Name</label>
                                            <input id="input-address" class="form-control" placeholder="Wife Name"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->wife_name : old('wife_name') }}"
                                                type="text" name="wife_name">
                                            @if ($errors->has('wife_name'))
                                                <span class="alert-danger">{{ $errors->first('wife_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Wife Contact
                                                Number</label>
                                            <input id="input-address" class="form-control"
                                                placeholder="Wife Mobile Number"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->wife_contact : old('wife_contact') }}"
                                                type="text" name="wife_contact">
                                            @if ($errors->has('wife_contact'))
                                                <span class="alert-danger">{{ $errors->first('wife_contact') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Father Name</label>
                                            <input id="input-address" class="form-control" placeholder="Father Name"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->father_name : old('father_name') }}"
                                                type="text" name="father_name">
                                            @if ($errors->has('father_name'))
                                                <span class="alert-danger">{{ $errors->first('father_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Father Contact
                                                Number</label>
                                            <input id="input-address" class="form-control"
                                                placeholder="Father Mobile Number"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->father_contact : old('father_contact') }}"
                                                type="text" name="father_contact">
                                            @if ($errors->has('father_contact'))
                                                <span class="alert-danger">{{ $errors->first('father_contact') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Mother Name</label>
                                            <input id="input-address" class="form-control" placeholder="Mother Name"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->mother_name : old('mother_name') }}"
                                                type="text" name="mother_name">
                                            @if ($errors->has('mother_name'))
                                                <span class="alert-danger">{{ $errors->first('mother_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Mother Contact
                                                Number</label>
                                            <input id="input-address" class="form-control"
                                                placeholder="Mother Mobile Number"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->mother_contact : old('mother_contact') }}"
                                                type="text" name="mother_contact">
                                            @if ($errors->has('mother_contact'))
                                                <span class="alert-danger">{{ $errors->first('mother_contact') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Brother Name</label>
                                            <input id="input-address" class="form-control" placeholder="Brother Name"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->brother_name : old('brother_name') }}"
                                                type="text" name="brother_name">
                                            @if ($errors->has('brother_name'))
                                                <span class="alert-danger">{{ $errors->first('brother_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Brother Contact
                                                Number</label>
                                            <input id="input-address" class="form-control"
                                                placeholder="Brother Mobile Number"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->brother_contact : old('brother_contact') }}"
                                                type="text" name="brother_contact">
                                            @if ($errors->has('brother_contact'))
                                                <span class="alert-danger">{{ $errors->first('brother_contact') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Sister Name</label>
                                            <input id="input-address" class="form-control" placeholder="Sister Name"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->sister_name : old('sister_name') }}"
                                                type="text" name="sister_name">
                                            @if ($errors->has('sister_name'))
                                                <span class="alert-danger">{{ $errors->first('sister_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Sister Contact
                                                Number</label>
                                            <input id="input-address" class="form-control"
                                                placeholder="Sister Mobile Number"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->sister_contact : old('sister_contact') }}"
                                                type="text" name="sister_contact">
                                            @if ($errors->has('sister_contact'))
                                                <span class="alert-danger">{{ $errors->first('sister_contact') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Child Name</label>
                                            <input id="input-address" class="form-control" placeholder="Child Name"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->child_name : old('child_name') }}"
                                                type="text" name="child_name">
                                            @if ($errors->has('child_name'))
                                                <span class="alert-danger">{{ $errors->first('child_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Child Contact
                                                Number</label>
                                            <input id="input-address" class="form-control"
                                                placeholder="Child Mobile Number"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->child_contact : old('child_contact') }}"
                                                type="text" name="child_contact">
                                            @if ($errors->has('child_contact'))
                                                <span class="alert-danger">{{ $errors->first('child_contact') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Reference Name</label>
                                            <input id="input-address" class="form-control" placeholder="Reference Name"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->refference_name : old('refference_name') }}"
                                                type="text" name="refference_name">
                                            @if ($errors->has('refference_name'))
                                                <span class="alert-danger">{{ $errors->first('refference_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Reference Contact
                                                Number</label>
                                            <input id="input-address" class="form-control"
                                                placeholder="Reference Mobile Number"
                                                value="{{ isset($User->UserDetails) ? $User->UserDetails->refference_contact : old('refference_contact') }}"
                                                type="text" name="refference_contact">
                                            @if ($errors->has('refference_contact'))
                                                <span
                                                    class="alert-danger">{{ $errors->first('refference_contact') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">
                                                Resume @if (isset($User->id))
                                                @else
                                                    {!! fieldRequired() !!}
                                                @endif
                                            </label>
                                            <input type="file" class="form-control" name="resume"
                                                id="customFileLang" lang="en">
                                            @if (isset($User->UserDetails))
                                                @if (isset($User->UserDetails->resume))
                                                    {{-- <img src="{{ asset('images/driver_image') . '/' . $User->UserDetails->resume }}"
                                                        alt="Image" class="brand-image"
                                                        style="width:100px;hieght:100px"> --}}
                                                    {{-- @else
                                                    <img src="{{ asset('images/no-image-icon-6.png') }}" alt="Image"
                                                        class="brand-image" style="width:100px;hieght:100px"> --}}
                                                    {{-- here view the image and pdf new tab  --}}
                                                    @if (isset($User->UserDetails->resume))
                                                        @if (file_exists(public_path('images/driver_image/' . $User->UserDetails->resume)))
                                                            <a style="margin-left: 10px" target="_blank"
                                                                href="{{ asset('images/driver_image/' . $User->UserDetails->resume) }}">
                                                                View </a>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                            @if ($errors->has('resume'))
                                                <span class="alert-danger">{{ $errors->first('resume') }}</span>
                                            @endif


                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <input class="btn btn-primary " type="submit"
                                        value={{ isset($User->id) ? 'Update' : 'Add' }}>
                                    <a class="btn btn-info mx-3" href=" {{ route('user') }} " value="Back">
                                        Back </a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('extra-js')
    <script>
        var calculateAge = function(birthday) {
            var now = new Date();
            var past = new Date(birthday);
            var nowYear = now.getFullYear();
            var pastYear = past.getFullYear();
            var age = nowYear - pastYear;

            return age;
        };

        $(document).on('change', '.year_count', function() {
            var birthday = $(this).val();
            // alert("hii");
            $("#input-age").val(calculateAge(birthday));
        });
    </script>
@endpush
