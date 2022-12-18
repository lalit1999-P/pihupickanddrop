@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">
                    {{ isset($VehicleModel->id) ? 'Vehicle Model Update' : 'Vehicle Model Add' }}
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('vehicle-model') }}">Vehicle Model</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ isset($VehicleModel->id) ? 'Vehicle Model Update' : 'Vehicle Model Add' }}
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
                        <form action="{{ route('store-vehicle-model') }}" method="POST">
                            @csrf
                            <section class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-primary">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="vehicle_model">Vehicle Model</label>
                                                    <input type="hidden" name="id"
                                                        value="{{ isset($VehicleModel) ? $VehicleModel->id : null }}">
                                                    <input type="text" id="vehicle_model" name="vehicle_model"
                                                        class="form-control"
                                                        value="{{ isset($VehicleModel) ? $VehicleModel->vehicle_model : old('vehicle_model') }}">
                                                    @if ($errors->has('vehicle_model'))
                                                        <span
                                                            class="alert-danger">{{ $errors->first('vehicle_model') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary float-left">
                                    {{ isset($VehicleModel->id) ? 'Update' : 'Add' }}
                                </button>
                                <a href="{{ route('vehicle-model') }}" class="btn btn-info mx-3">Back</a>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
