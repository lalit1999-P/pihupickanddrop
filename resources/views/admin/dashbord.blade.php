@extends('layouts.master')
@section('content')

    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">Dashboard</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
        <!-- Sales chart -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- Column -->
            @if (auth()->user()->user_type == 1)
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Total Employee User
                            </h4>
                            <div class="text-end">
                                <h2 class="font-light mb-0"><i class="ti-user text-success"></i>
                                    {{ $TotalCount['EmployeeUser'] }}</h2>
                                <span class="text-muted">Employee User</span>
                            </div>

                            {{-- <span class="text-success">80</span> --}}
                            {{-- <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 80%; height: 6px;"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Total Driver Users
                            </h4>
                            <div class="text-end">
                                <h2 class="font-light mb-0"><i class="ti-user text-info"></i>
                                    {{ $TotalCount['DriverUsers'] }}
                                </h2>
                                <span class="text-muted">Driver Users</span>
                            </div>
                            {{-- <span class="text-info">30%</span> --}}
                            {{-- <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 30%; height: 6px;"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Total Vehicle Model</h4>
                            <div class="text-end">
                                <h2 class="font-light mb-0"><i class="ti-car text-success"></i>
                                    {{ $TotalCount['VehicleModel'] }}</h2>
                                <span class="text-muted">Vehicle Model</span>
                            </div>
                            {{-- <span class="text-success">80%</span>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 80%; height: 6px;"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Total Vehicle Variant</h4>
                            <div class="text-end">
                                <h2 class="font-light mb-0"><i class="ti-car text-success"></i>
                                    {{ $TotalCount['VehicleVariant'] }}</h2>
                                <span class="text-muted">Vehicle Variant</span>
                            </div>
                            {{-- <span class="text-success">80%</span>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 80%; height: 6px;"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Total Service Order</h4>
                        <div class="text-end">
                            <h2 class="font-light mb-0"><i class="ti-arrow-up text-success"></i> {{ $TotalCount['Order'] }}
                            </h2>
                            <span class="text-muted">Service Order</span>
                        </div>
                        {{-- <span class="text-success">80%</span>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 80%; height: 6px;"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div> --}}
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- ============================================================== -->
        <!-- Sales chart -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Table -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-md-flex">
                            <h4 class="card-title col-md-10 mb-md-0 mb-3 align-self-center">Latest Service Order</h4>

                        </div>
                        <div class="table-responsive mt-5">
                            <table class="table stylish-table no-wrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        {{-- <th>Price</th> --}}
                                        <th>Email</th>
                                        <th>Mobile Number</th>
                                        <th>Model</th>
                                        <th>Varient</th>
                                        <th>Order Date Time</th>
                                        @if (auth()->user()->user_type == '1')
                                            <th>Assign Driver</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @if (!empty($TotalCount['OrderDetails'][0]))
                                        @foreach ($TotalCount['OrderDetails'] as $value)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $value->first_name }} {{ $value->sur_name }} </td>
                                                </td>
                                                <td>{{ $value->email_id }}</td>
                                                <td>{{ $value->mobile_no }}</td>
                                                <td>{{ $value->vehicleModel ? $value->vehicleModel->vehicle_model : '' }}
                                                </td>
                                                <td>{{ $value->Varient ? $value->Varient->vehicle_variant : '' }}
                                                </td>
                                                <td>{{ Illuminate\Support\Carbon::parse($value->created_at)->format('Y-m-d h:i:s a') }}
                                                </td>
                                                {{-- <td>{{ $value->Category ? $value->Category->category : '' }}</td> --}}
                                                @if (auth()->user()->user_type == '1')
                                                    <td>
                                                        @if ($value->driver_id == null)
                                                            <span class="badge badge-success">New
                                                                Order</span>
                                                        @else
                                                            <span
                                                                class="badge badge-primary">{{ $value->DriverUsers->name }}</span>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7">No data available in table
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Table -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Recent blogss -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Recent blogss -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
@endsection
