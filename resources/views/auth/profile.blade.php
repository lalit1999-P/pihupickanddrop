@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">Profile Update</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile Update</li>
                        </ol>
                    </nav>
                </div>
            </div>
            {{-- <div class="col-md-6 col-4 align-self-center">
                <div class="text-end upgrade-btn">
                    <a href="{{ route('create-vehicle-model') }}"
                        class="btn btn-success d-none d-md-inline-block text-white"><i class="fas fa-plus"></i>Add Vehicle
                        Model
                    </a>
                    <a href="{{ route('export-vehicle-model') }}"
                        class="btn btn-info d-none d-md-inline-block text-white"><i class="fas fa-note"></i> Excel Export
                    </a>
                </div>
            </div> --}}
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
                        <form action="{{ route('profile-update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <section class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-primary">
                                            <div class="card-body">
                                                <input type="hidden" name="id"
                                                    value="{{ isset($User) ? $User->id : null }}">
                                                <div class="form-group">
                                                    @if (isset($User->image))
                                                        <img src="{{ asset('images/employee_image') . '/' . $User->image }}"
                                                            alt="image" class="brand-image profile-icon-circle"
                                                            style="width:150px;hieght:150px">
                                                    @else
                                                        <img src="{{ asset('images/no-image-icon-6.png') }}" alt="image"
                                                            class="brand-image profile-icon-circle"
                                                            style="width:150px;hieght:150px">
                                                    @endif
                                                    <br />
                                                    <label for="inputClientCompany">Image</label>
                                                    <input type="file" id="image" accept="image/png, image/jpeg"
                                                        name="image" class="form-control"
                                                        value="{{ isset($User) ? $User->image : old('image') }}">
                                                    @if ($errors->has('image'))
                                                        <span class="alert-danger">{{ $errors->first('image') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputClientCompany">Name</label>
                                                    <input type="text" id="name" name="name" class="form-control"
                                                        value="{{ isset($User) ? $User->name : old('name') }}">
                                                    @if ($errors->has('name'))
                                                        <span class="alert-danger">{{ $errors->first('name') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputClientCompany">Email</label>
                                                    <input type="text" id="email" name="email" class="form-control"
                                                        value="{{ isset($User) ? $User->email : old('email') }}" disabled>
                                                    @if ($errors->has('email'))
                                                        <span class="alert-danger">{{ $errors->first('email') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputClientCompany">Contact</label>
                                                    <input type="text" id="contact" name="contact" class="form-control"
                                                        value="{{ isset($User) ? $User->contact : old('contact') }}">
                                                    @if ($errors->has('contact'))
                                                        <span class="alert-danger">{{ $errors->first('contact') }}</span>
                                                    @endif
                                                </div>
                                                @if (isset($User))
                                                @else
                                                    <div class="form-group">
                                                        <label for="inputClientCompany">Password</label>
                                                        <input type="password" id="password" name="password"
                                                            class="form-control"
                                                            value="{{ isset($User) ? $User->password : old('password') }}"
                                                            required>
                                                        @if ($errors->has('password'))
                                                            <span
                                                                class="alert-danger">{{ $errors->first('password') }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <label for="inputClientCompany">Address</label>
                                                    <input type="text" id="address" name="address" class="form-control"
                                                        value="{{ isset($User) ? $User->address : old('address') }}">
                                                    @if ($errors->has('address'))
                                                        <span class="alert-danger">{{ $errors->first('address') }}</span>
                                                    @endif
                                                </div>
                                                <br />
                                                <h6 class="heading-small text-muted mb-4">Password Change</h6>
                                                <div class="form-group">
                                                    <label for="inputClientCompany">Old Password</label>
                                                    <input type="text" id="oldpassword" name="oldpassword"
                                                        class="form-control">
                                                    @if ($errors->has('oldpassword'))
                                                        <span
                                                            class="alert-danger">{{ $errors->first('oldpassword') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputClientCompany">New Password</label>
                                                    <input type="text" id="newpassword" name="newpassword"
                                                        class="form-control">
                                                    @if ($errors->has('newpassword'))
                                                        <span
                                                            class="alert-danger">{{ $errors->first('newpassword') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-success float-left">
                                    submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
