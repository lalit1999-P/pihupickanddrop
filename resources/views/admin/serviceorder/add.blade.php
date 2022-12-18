@extends('layouts.master')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">
                    {{ isset($Order->id) ? 'Service Order Update' : 'Add Service Order' }}
                </h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('serviceorder') }}">Vehicle Service Order</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ isset($Order->id) ? 'Service Order Update' : 'Add Service Order' }}
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
                        <form action="{{ route('store-serviceorder') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ isset($Order) ? $Order->id : null }}">
                            <input type="hidden" name="user_id"
                                value="{{ isset($Order->user_id) ? $Order->user_id : null }}">
                            <div class="pl-lg-4">
                                <br>
                                <h6 class="heading-small text-muted mb-4">Vehicle Details</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Vehicle Number {!! fieldRequired() !!}</label>

                                            <input type="text" id="reg_number" name="reg_number" class="form-control"
                                                value="{{ isset($Order) ? $Order->reg_number : old('reg_number') }}">
                                            @if ($errors->has('reg_number'))
                                                <span class="alert-danger">{{ $errors->first('reg_number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Mobile Number {!! fieldRequired() !!}</label>
                                            <input type="number" id="mobile_no" name="mobile_no" class="form-control"
                                                value="{{ isset($Order) ? $Order->mobile_no : old('mobile_no') }}">
                                            @if ($errors->has('mobile_no'))
                                                <span class="alert-danger">{{ $errors->first('mobile_no') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Vehicle Model {!! fieldRequired() !!}</label>
                                            <select class="form-control select2" onchange="getVarient(this)"
                                                name="vehicle_model" style="width: 100%;">
                                                <option value=""> -Select Vehicle Model- </option>
                                                @foreach ($vehicleModel as $model)
                                                    @if (old('vehicle_model'))
                                                        <?php $id = isset($Order) ? $Order->vehicle_model : null; ?>
                                                        <option value="{{ $model->id }}"
                                                            {{ old('vehicle_model') == $model->id ? 'selected' : '' }}>
                                                            {{ $model->vehicle_model }}
                                                        </option>
                                                    @else
                                                        <?php $id = isset($Order) ? $Order->vehicle_model : null; ?>
                                                        <option value="{{ $model->id }}"
                                                            @if ($model->id == $id) selected @endif>
                                                            {{ $model->vehicle_model }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if ($errors->has('vehicle_model'))
                                                <span class="alert-danger">{{ $errors->first('vehicle_model') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Vehicle Variant {!! fieldRequired() !!}</label>
                                            <select class="form-control select2" id="vehicle_varient_id"
                                                name="vehicle_variant" style="width: 100%;">

                                                <option value=""> -- Select Vehicle Variant -- </option>
                                                @if (isset($vehicleVarient))
                                                    @foreach ($vehicleVarient as $vvr)
                                                        @if (old('vehicle_variant'))
                                                            <option value="{{ $vvr->id }}"
                                                                {{ old('vehicle_model') == $vvr->id ? 'selected' : '' }}>
                                                                {{ $vvr->vehicle_variant }} </option>
                                                        @else
                                                            <option value=" {{ $vvr->id }} "
                                                                {{ $Order->vehicle_variant == $vvr->id ? 'selected' : '' }}>
                                                                {{ $vvr->vehicle_variant }} </option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <option value=""> -No vehicle variant - </option>
                                                @endif

                                            </select>
                                            @if ($errors->has('vehicle_variant'))
                                                <span class="alert-danger">{{ $errors->first('vehicle_variant') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @if (auth()->user()->user_type == '1')
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Driver Detail</label>
                                                <select class="form-control select2" name="driver_id" style="width: 100%;">
                                                    <option value="">-Select Driver-</option>
                                                    @foreach ($DriverDeail as $Driver)
                                                        @if (old('driver_id'))
                                                            <option value="{{ $Driver->id }}"
                                                                {{ old('driver_id') == $Driver->id ? 'selected' : "'" }}>
                                                                {{ $Driver->name }}
                                                            </option>
                                                        @else
                                                            <?php $idDriver = isset($Order) ? $Order->driver_id : null; ?>
                                                            <option value="{{ $Driver->id }}"
                                                                @if ($Driver->id == $idDriver) selected @endif>
                                                                {{ $Driver->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('driver_id'))
                                                    <span class="alert-danger">{{ $errors->first('driver_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif


                                </div>
                                <br><br>
                                <h6 class="heading-small text-muted mb-4">Customer Details</h6>
                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Full Name {!! fieldRequired() !!}</label>
                                            <input type="text" id="full_name" name="full_name" class="form-control"
                                                value="{{ isset($Order) ? $Order->full_name : old('full_name') }}">
                                            @if ($errors->has('full_name'))
                                                <span class="alert-danger">{{ $errors->first('full_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Email Id {!! fieldRequired() !!}</label>
                                            <input type="text" id="email_id" name="email_id" class="form-control"
                                                value="{{ isset($Order) ? $Order->email_id : old('email_id') }}">
                                            @if ($errors->has('email_id'))
                                                <span class="alert-danger">{{ $errors->first('email_id') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                    {{-- <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Middle name </label>
                                            <input type="text" id="sur_name" name="sur_name" class="form-control"
                                                value="{{ isset($Order) ? $Order->sur_name : old('sur_name') }}">
                                            @if ($errors->has('sur_name'))
                                                <span class="alert-danger">{{ $errors->first('sur_name') }}</span>
                                            @endif
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row">
                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name {!! fieldRequired() !!}</label>
                                            <input type="text" id="last_name" name="last_name" class="form-control"
                                                value="{{ isset($Order) ? $Order->last_name : old('last_name') }}">
                                            @if ($errors->has('last_name'))
                                                <span class="alert-danger">{{ $errors->first('last_name') }}</span>
                                            @endif
                                        </div>
                                    </div> --}}

                                </div>
                            </div>

                            {{-- <div class="pl-lg-4">
                                <br>
                                <h6 class="heading-small text-muted mb-4">Address Detail</h6>
                                <hr />
                               
                            </div> --}}

                            <div class="pl-lg-4">
                                <br>
                                <h6 class="heading-small text-muted mb-4">Service Detail</h6>
                                <hr />
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Service Center {!! fieldRequired() !!}</label>
                                            <select class="form-control select2" name="location_id" style="width: 100%;">
                                                <option value=" ">Select Location</option>
                                                @foreach ($Location as $Locations)
                                                    @if (old('location_id'))
                                                        <option value="{{ $Locations->id }}"
                                                            {{ old('location_id') == $Locations->id ? 'selected' : "'" }}>
                                                            {{ $Locations->location }}
                                                        </option>
                                                    @else
                                                        <?php $id = isset($Order) ? $Order->location_id : null; ?>
                                                        <option value="{{ $Locations->id }}"
                                                            @if ($Locations->id == $id) selected @endif>
                                                            {{ $Locations->location }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if ($errors->has('location_id'))
                                                <span class="alert-danger">{{ $errors->first('location_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Invoice Date</label>
                                            @if (isset($Order))
                                                <input type="date" id="invoice_date" name="invoice_date"
                                                    value="{{ date('Y-m-d', strtotime($Order->invoice_date)) }}"
                                                    class="form-control">
                                            @else
                                                <input type="date" id="invoice_date" name="invoice_date"
                                                    class="form-control">
                                            @endif
                                            @if ($errors->has('invoice_date'))
                                                <span class="alert-danger">{{ $errors->first('invoice_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Service Type {!! fieldRequired() !!}</label>
                                            <select class="form-control select2" name="service_type"
                                                style="width: 100%;">
                                                <option value="service_type">Select Vehicle Model</option>
                                                @if (old('service_type'))
                                                    <option value="1"
                                                        {{ old('service_type') == '1' ? 'selected' : '' }}>
                                                        Free Service</option>
                                                    <option value="2"
                                                        {{ old('service_type') == '2' ? 'selected' : '' }}>
                                                        Paid Service</option>
                                                    <option value="3"
                                                        {{ old('service_type') == '3' ? 'selected' : '' }}>
                                                        Accidential</option>
                                                @else
                                                    <option value="1"
                                                        @if (1 == isset($Order) ? $Order->service_type : null) selected @endif>
                                                        Free Service</option>
                                                    <option value="2"
                                                        @if (2 == isset($Order) ? $Order->service_type : null) selected @endif>
                                                        Paid Service</option>
                                                    <option value="3"
                                                        @if (3 == isset($Order) ? $Order->service_type : null) selected @endif>
                                                        Accidential</option>
                                                @endif

                                            </select>
                                            @if ($errors->has('service_type'))
                                                <span class="alert-danger">{{ $errors->first('service_type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Payment Method {!! fieldRequired() !!}</label>
                                            <select class="form-control select2" name="payment_method"
                                                style="width: 100%;">
                                                <option value=" ">Select Payment Method</option>
                                                @if (old('payment_method'))
                                                    <option value="1"
                                                        {{ old('payment_method') == '1' ? 'selected' : '' }}>
                                                        Payment on delivery</option>
                                                    <option value="2"
                                                        {{ old('payment_method') == '2' ? 'selected' : '' }}>
                                                        Online Payment</option>
                                                @else
                                                    <option value="1"
                                                        @if (1 == isset($Order) ? $Order->payment_method : null) selected @endif>
                                                        Payment on delivery</option>
                                                    <option value="2"
                                                        @if (2 == isset($Order) ? $Order->payment_method : null) selected @endif>
                                                        Online Payment</option>
                                                @endif

                                            </select>
                                            @if ($errors->has('payment_method'))
                                                <span class="alert-danger">{{ $errors->first('payment_method') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Invoice Amount </label>
                                            <input type="number" id="price" name="price" class="form-control"
                                                value="{{ isset($Order) ? $Order->price : old('price') }}">
                                            @if ($errors->has('price'))
                                                <span class="alert-danger">{{ $errors->first('price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Payble Amount</label>
                                            <input type="number" id="payble_amount" name="payble_amount"
                                                class="form-control"
                                                value="{{ isset($Order) ? $Order->payble_amount : old('payble_amount') }}">

                                            @if ($errors->has('payble_amount'))
                                                <span class="alert-danger">{{ $errors->first('payble_amount') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Pick Up Date {!! fieldRequired() !!}</label>
                                            <input type="date" id="pick_up_date" name="pick_up_date"
                                                class="form-control"
                                                value="{{ isset($Order) ? $Order->pick_up_date : old('pick_up_date') }}">
                                            @if ($errors->has('pick_up_date'))
                                                <span class="alert-danger">{{ $errors->first('pick_up_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Pick Up Time {!! fieldRequired() !!}</label>
                                            <select class="form-control select2" name="pick_up_time" id="pick_up_time"
                                                style="width: 100%;">
                                                <option value=" ">Select Pick Up Time</option>
                                                @foreach (timeSlot() as $timeslot)
                                                    @if (old('pick_up_time'))
                                                        <option value="{{ $timeslot }}"
                                                            {{ old('pick_up_time') == $timeslot ? 'selected' : '' }}>
                                                            {{ $timeslot }}
                                                        </option>
                                                    @else
                                                        <?php $id = isset($Order) ? $Order->pick_up_time : null; ?>
                                                        <option value="{{ $timeslot }}"
                                                            @if ($timeslot == $id) selected @endif>
                                                            {{ $timeslot }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if ($errors->has('pick_up_time'))
                                                <span class="alert-danger">{{ $errors->first('pick_up_time') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="checkbox" id="same_drop_off_date" class="same_drop_off_date"
                                                name="same_drop_off_date" value="1">
                                            <label>Drop off Date</label>
                                            <input type="date" id="drop_off_date" name="drop_off_date"
                                                class="form-control"
                                                value="{{ isset($Order) ? $Order->drop_off_date : old('drop_off_date') }}">
                                            @if ($errors->has('drop_off_date'))
                                                <span class="alert-danger">{{ $errors->first('drop_off_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="checkbox" id="same_drop_off_time" class="same_drop_off_time"
                                                name="same_drop_off_time" value="1">
                                            <label>Drop off Time</label>
                                            <select class="form-control select2" id="drop_off_time" name="drop_off_time"
                                                style="width: 100%;">
                                                <option value=" ">Select Drop off Time</option>
                                                @foreach (timeSlot() as $timeslot)
                                                    @if (old('drop_off_time'))
                                                        <option value="{{ $timeslot }}"
                                                            {{ old('drop_off_time') == $timeslot ? 'selected' : '' }}>
                                                            {{ $timeslot }}
                                                        </option>
                                                    @else
                                                        <?php $id = isset($Order) ? $Order->drop_off_time : null; ?>
                                                        <option value="{{ $timeslot }}"
                                                            @if ($timeslot == $id) selected @endif>
                                                            {{ $timeslot }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if ($errors->has('drop_off_time'))
                                                <span class="alert-danger">{{ $errors->first('drop_off_time') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Pickup Location Address {!! fieldRequired() !!}</label>
                                            <textarea style="margin-top:16px " type="text" id="pickup_address" name="pickup_address" class="form-control"> {{ isset($Order) ? $Order->pickup_address : '' }}</textarea>
                                            @if ($errors->has('pickup_address'))
                                                <span class="alert-danger">{{ $errors->first('pickup_address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="checkbox" id="same_location" class="same_location"
                                                name="same_location" value="1">
                                            <label> Same As Drop off Address {!! fieldRequired() !!}</label>
                                        </div>
                                        <div class="form-group">
                                            <textarea type="text" id="drop_address" name="drop_address" class="form-control"> {{ isset($Order) ? $Order->drop_address : '' }}</textarea>
                                            @if ($errors->has('drop_address'))
                                                <span class="alert-danger">{{ $errors->first('drop_address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-12">
                                        
                                    </div> --}}
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Service Detail {!! fieldRequired() !!}</label>
                                            <textarea type="text" id="service_detail" name="service_detail" class="form-control"> {{ isset($Order) ? $Order->service_detail : '' }}</textarea>
                                            @if ($errors->has('service_detail'))
                                                <span class="alert-danger">{{ $errors->first('service_detail') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary float-left" type="submit"
                                        value="{{ isset($Order->id) ? ' Update' : 'Add' }}">
                                    <a class="btn btn-info mx-3" href=" {{ route('serviceorder') }} " value="Back">
                                        Back </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script>
        function getVarient(e) {
            var varient_id = e.value;
            if (varient_id) {
                $.ajax({
                    type: "post",
                    url: "{{ route('get-vehicle-verient') }}",
                    data: {
                        "varient_id": varient_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(result) {
                        $('#vehicle_varient_id').html('<option value="">-- Select Varient --</option>');

                        result.forEach(a => {
                            $('#vehicle_varient_id').append(
                                `<option value="${a.id}"> ${a.vehicle_variant} </option>`);
                        });

                    }
                });
            }

        }
        $(document).ready(function() {
            $('.same_location').click(function() {
                if ($('.same_location').prop("checked")) {
                    var add = $('#pickup_address').val();
                    $("textarea#drop_address").html(add)
                }
            });
        });
    </script>

@endsection
