@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">Update Passsword</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user') }}">Driver Users</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Update Passsword
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
                        <form action="{{ route('update-password', ['id' => $id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-password">Password
                                                {!! fieldRequired() !!}</label>
                                            <div class="input-group">
                                                <input type="password" id="password_user" class="form-control "
                                                    placeholder="Password" value="{{ old('password') ?? '' }}"
                                                    name="password">
                                                <div class="input-group-append show_password">
                                                    <div class="input-group-text">
                                                        <span class="fa fa-eye-slash"></span>
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
                                            <label class="form-control-label" for="input-username">Confirm
                                                Password {!! fieldRequired() !!}</label>
                                            <div class="input-group">
                                                <input type="password" id="password_confirmation" class="form-control "
                                                    placeholder="Confirm Password"
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
                                </div>
                                <div class="form-group">

                                    <input class="btn btn-primary " type="submit" value={{ isset($id) ? 'Update' : '' }}>
                                    <a class="btn btn-info mx-3" href=" {{ route('user') }} " value="Back">
                                        Back </a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
