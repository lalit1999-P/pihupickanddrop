@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">{{ isset($Location->id) ? 'Location Update' : 'Location Add' }} </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('location') }}">Location</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ isset($Location->id) ? 'Location Update' : 'Location Add' }}
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
                        <form action="{{ route('store-location') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary">
                                        <div class="card-body">
                                            <input type="hidden" name="id"
                                                value="{{ isset($Location) ? $Location->id : null }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="inputClientCompany">Location Name{!! fieldRequired() !!}
                                                        </label>
                                                        <input type="text" id="location" name="location"
                                                            class="form-control"
                                                            value="{{ isset($Location) ? $Location->location : old('location') }}">
                                                        @if ($errors->has('location'))
                                                            <span
                                                                class="alert-danger">{{ $errors->first('location') }}</span>
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
                                                                    {{ isset($Location->status) ? ($Location->status == '1' ? 'selected' : '') : '' }}>
                                                                    Active </option>
                                                                <option value="0"
                                                                    {{ isset($Location->status) ? ($Location->status == '0' ? 'selected' : '') : '' }}>
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
                                                                        <?php $idAdminUser = isset($Location) ? $Location->user_id : null; ?>
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

                                                <textarea id="address" name="address" style="height:150px" class="form-control">{{ (isset($Location) ? $Location->address : isset($Location)) ? $Location->address : old('address') }}</textarea>
                                                @if ($errors->has('address'))
                                                    <span class="alert-danger">{{ $errors->first('address') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">

                                                <button type="submit" class="btn btn-primary float-left">
                                                    {{ isset($Location->id) ? 'Update' : 'Add' }}</li>
                                                </button>
                                                <a class="btn btn-info mx-3" href=" {{ route('location') }} "
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
