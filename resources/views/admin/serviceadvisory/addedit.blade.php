@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">{{ isset($User->id) ? 'Service Advisory Update' : 'Service Advisory Add' }}
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('service-advisory') }}">Service Advisory</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ isset($User->id) ? 'Service Advisory Update' : 'Service Advisory Add' }}
                            </li>
                        </ol>
                    </nav>
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
                        <form action="{{ route('store-service-advisory') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary">
                                        <div class="card-body">
                                            <input type="hidden" name="id"
                                                value="{{ isset($User) ? $User->id : null }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">

                                                        <label for="inputClientCompany">Name
                                                            {!! fieldRequired() !!}</label>
                                                        <input type="text" id="name" name="name"
                                                            class="form-control"
                                                            value="{{ isset($User) ? $User->name : old('name') }}">
                                                        @if ($errors->has('name'))
                                                            <span class="alert-danger">{{ $errors->first('name') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="inputClientCompany">Email
                                                            {!! fieldRequired() !!}</label>
                                                        <input type="text" id="email" name="email"
                                                            class="form-control"
                                                            value="{{ isset($User) ? $User->email : old('email') }}">
                                                        @if ($errors->has('email'))
                                                            <span class="alert-danger">{{ $errors->first('email') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="inputClientCompany">Mobile
                                                            Number{!! fieldRequired() !!}
                                                        </label>
                                                        <input type="number" id="contact" name="contact"
                                                            class="form-control"
                                                            value="{{ isset($User) ? $User->contact : old('contact') }}">
                                                        @if ($errors->has('contact'))
                                                            <span
                                                                class="alert-danger">{{ $errors->first('contact') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="input-username"> Status
                                                            {!! fieldRequired() !!}</label>
                                                        <select class="form-control" name="status" id="status">
                                                            @if (old('status'))
                                                                <option value="1"
                                                                    {{ old('status') == '1' ? 'selected' : '' }}>
                                                                    Active </option>
                                                                <option value="0"
                                                                    {{ old('status') == '0' ? 'selected' : '' }}>
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
                                                            <span
                                                                class="alert-danger">{{ $errors->first('status') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="row">
                                                <div class="col-md-6">
                                                    @if (!isset($User))
                                                        <div class="form-group">
                                                            <label for="inputClientCompany">Password
                                                                {!! fieldRequired() !!}</label>
                                                            <div class="input-group">
                                                                <input type="password" id="password_user"
                                                                    class="form-control " placeholder="Password"
                                                                    value="{{ old('password') ?? '' }}" name="password"
                                                                    required>
                                                                <div class="input-group-append show_password">
                                                                    <div class="input-group-text">
                                                                        <span class="fa fa-eye-slash"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if ($errors->has('password'))
                                                                <span
                                                                    class="alert-danger">{{ $errors->first('password') }}</span>
                                                            @endif
                                                        </div>
                                                </div>
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label class="form-control-label"
                                                            for="password_confirmation">Confirm
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
                                            </div> --}}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="inputClientCompany"> Profile
                                                            Image
                                                            {{-- {!! fieldRequired() !!} --}}
                                                        </label>
                                                        <input type="file" id="image" accept="image/png, image/jpeg"
                                                            name="image" class="form-control"
                                                            value="{{ isset($User) ? $User->image : old('image') }}">
                                                        @if (isset($User))
                                                            @if (isset($User))
                                                                @if (file_exists('images/serviceadvisory/' . $User->image))
                                                                    <img src="{{ asset('images/serviceadvisory') . '/' . $User->image }}"
                                                                        alt="image" class="brand-image"
                                                                        style="width:100px;hieght:100px">
                                                                @endif
                                                            @else
                                                                <img src="{{ asset('images/no-image-icon-6.png') }}"
                                                                    alt="image" class="brand-image"
                                                                    style="width:100px;hieght:100px">
                                                            @endif
                                                        @endif
                                                        @if ($errors->has('image'))
                                                            <span class="alert-danger">{{ $errors->first('image') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
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
                                            <div class="form-group">
                                                <label for="inputClientCompany">Address {!! fieldRequired() !!}</label>

                                                <textarea id="address" name="address" style="height:150px" class="form-control">{{ (isset($User) ? $User->address : isset($User)) ? $User->address : old('address') }}</textarea>
                                                @if ($errors->has('address'))
                                                    <span class="alert-danger">{{ $errors->first('address') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">

                                                <button type="submit" class="btn btn-primary float-left">
                                                    {{ isset($User->id) ? 'Update' : 'Add' }}</li>
                                                </button>
                                                <a class="btn btn-info mx-3" href=" {{ route('service-advisory') }} "
                                                    value="Back"> Back </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
