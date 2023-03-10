@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">Vehicle Model List</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Vehicle Model</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-6 col-4 align-self-center">
                <div class="text-end upgrade-btn">
                    <a href="{{ route('create-vehicle-model') }}"
                        class="btn btn-success d-none d-md-inline-block text-white"><i class="fas fa-plus"></i>Add Vehicle
                        Model
                    </a>
                    <a href="{{ route('export-vehicle-model') }}"
                        class="btn btn-info d-none d-md-inline-block text-white"><i class="fas fa-note"></i> Excel Export
                    </a>
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
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($vehiclemodel as $value)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $value->vehicle_model }}</td>

                                        <td>
                                            <form method="POST" action="{{ route('delete-vehicle-model', $value->id) }}">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <a href="{{ route('edit-vehicle-model', $value->id) }}"
                                                    class="btn btn-info btn-sm"> <i style="color: black" class="fas fa-pencil-alt">
                                                    </i></a>
                                                <button type="submit" class="btn btn-danger btn-sm show_confirm"
                                                    data-toggle="tooltip" title='Delete'><i
                                                        class="fas fa-trash"></i></button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
