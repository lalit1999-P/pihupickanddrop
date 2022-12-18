@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">Service Order List</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Service Order</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-6 col-4 align-self-center">
                <div class="text-end upgrade-btn">
                    <a href="{{ route('create-serviceorder') }}"
                        class="btn btn-success d-none d-md-inline-block text-white"><i class="fas fa-plus"></i>Add Service
                        Order
                    </a>
                    <a href="{{ route('export-serviceorder') }}" class="btn btn-info d-none d-md-inline-block text-white"><i
                            class="fas fa-note"></i> Excel Export
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
                                    <th>Customer Name</th>
                                    {{-- <th>Price</th> --}}
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                    <th>Vehicle Number</th>
                                    <th>Model</th>
                                    <th>Varient</th>
                                    @if (auth()->user()->user_type == '1')
                                        <th>Assign Driver</th>
                                    @endif
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($Order as $value)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $value->full_name }} </td>
                                        </td>
                                        <td>{{ $value->email_id }}</td>
                                        <td>{{ $value->mobile_no }}</td>
                                        <td>{{ $value->reg_number ?? '' }}
                                        </td>
                                        <td>{{ $value->vehicleModel ? $value->vehicleModel->vehicle_model : '' }}
                                        </td>
                                        <td>{{ $value->Varient ? $value->Varient->vehicle_variant : '' }}
                                        </td>

                                        @if (auth()->user()->user_type == '1')
                                            <td>
                                                @if ($value->driver_id == null)
                                                    <span class="badge badge-info">New
                                                        Order</span>
                                                @else
                                                    <span class="badge badge-success">{{ $value->DriverUsers->name }}</span>
                                                @endif
                                            </td>
                                        @endif
                                        <td>
                                            <form method="POST" action="{{ route('delete-serviceorder', $value->id) }}">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <a href="{{ route('edit-serviceorder', $value->id) }}"
                                                    class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                                <button type="submit" class="btn btn-danger btn-sm show_confirm"
                                                    data-toggle="tooltip" title='Delete'> <i class="fas fa-trash"></i>
                                                </button>
                                                @if ($value->invoice_date != null && $value->payble_amount != null)
                                                    <a href="{{ route('view-invoice-serviceorder', $value->id) }}"
                                                        class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                                                @endif
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
