@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">
                    {{ isset($VehicleVariant->id) ? 'Vehicle Variant Update' : 'Vehicle Variant Add' }}
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('vehicle-variant') }}">Vehicle Variant</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ isset($VehicleVariant->id) ? 'Vehicle Variant Update' : 'Vehicle Variant Add' }}</li>
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
                        <form action="{{ route('store-vehicle-variant') }}" method="POST">
                            @csrf
                            <section class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-primary">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Vehicle Model</label>
                                                    <input type="hidden" name="id"
                                                        value="{{ isset($VehicleVariant) ? $VehicleVariant->id : null }}">
                                                    <select class="form-control select2" name="vehicle_model"
                                                        style="width: 100%;">
                                                        <option value=" ">Select Vehicle Model</option>
                                                        @foreach ($VehicleModel as $model)
                                                            @if (old('vehicle_model'))
                                                                <option value="{{ $model->id }}"
                                                                    {{ old('vehicle_model') == $model->id ? 'selected' : '' }}>
                                                                    {{ $model->vehicle_model }}
                                                                </option>
                                                            @else
                                                                <?php $id = isset($VehicleVariant) ? $VehicleVariant->vehicle_model : null; ?>
                                                                <option value="{{ $model->id }}"
                                                                    @if ($model->id == $id) selected @endif>
                                                                    {{ $model->vehicle_model }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('vehicle_model'))
                                                        <span
                                                            class="alert-danger">{{ $errors->first('vehicle_model') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputClientCompany">Vehicle Varient Name</label>
                                                    <input type="text" id="vehicle_variant" name="vehicle_variant"
                                                        class="form-control"
                                                        value="{{ isset($VehicleVariant) ? $VehicleVariant->vehicle_variant : old('vehicle_variant') }}">
                                                    @if ($errors->has('vehicle_variant'))
                                                        <span
                                                            class="alert-danger">{{ $errors->first('vehicle_variant') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary float-left">
                                    {{ isset($VehicleVariant->id) ? 'Update' : 'Add' }}</button>
                                <a href="{{ route('vehicle-variant') }}" class="btn btn-info mx-3">Back</a>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
