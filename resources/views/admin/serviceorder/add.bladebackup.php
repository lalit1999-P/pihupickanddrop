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
                        <form action="{{ route('store-serviceorder') }}" method="POST" enctype='multipart/form-data'>
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

                                                <option value=""> -Select Vehicle Variant- </option>
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
                                @if (auth()->user()->user_type == '1' or auth()->user()->user_type == '2')
                                    <div class="row">
                                        @if (isset($Order))
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Driver Detail</label>
                                                    <select class="form-control select2" name="driver_id"
                                                        style="width: 100%;">
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
                                        @if (auth()->user()->user_type == 1)
                                            <div class="col-md-6">
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
                                            </div>
                                        @endif
                                    </div>
                                    @if (isset($Order))
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Service Advisory</label>
                                                    <select class="form-control select2" name="service_advisory_id"
                                                        style="width: 100%;">
                                                        <option value="">-Select Service Advisory-</option>
                                                        @foreach ($serviceAdvisorys as $serviceAdvisory)
                                                            @if (old('service_advisory_id'))
                                                                <option value="{{ $serviceAdvisory->id }}"
                                                                    {{ old('service_advisory_id') == $serviceAdvisory->id ? 'selected' : "'" }}>
                                                                    {{ $serviceAdvisory->name }}
                                                                </option>
                                                            @else
                                                                <?php $idServiceAdvisory = isset($Order) ? $Order->user_id : null; ?>
                                                                <option value="{{ $serviceAdvisory->id }}"
                                                                    @if ($serviceAdvisory->id == $idServiceAdvisory) selected @endif>
                                                                    {{ $serviceAdvisory->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('service_advisory_id'))
                                                        <span
                                                            class="alert-danger">{{ $errors->first('service_advisory_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Dealer Name</label>
                                                    <input type="text" id="dealer_name" name="dealer_name"
                                                        class="form-control"
                                                        value="{{ isset($Order) ? $Order->dealer_name : old('dealer_name') }}">
                                                    @if ($errors->has('dealer_name'))
                                                        <span
                                                            class="alert-danger">{{ $errors->first('dealer_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
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
                                    {{-- <div class="col-md-6">
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
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Service Type </label>
                                            <select class="form-control select2" name="service_type"
                                                style="width: 100%;">
                                                <option value=" ">Select Service Type</option>
                                                @foreach (getServiceType() as $serviceType)
                                                    @if (old('service_type'))
                                                        <option value="{{ $serviceType['id'] }}"
                                                            {{ old('service_type') == $serviceType['id'] ? 'selected' : "'" }}>
                                                            {{ $serviceType['name'] }}
                                                        </option>
                                                    @else
                                                        <?php $idServiceType = isset($Order) ? $Order->service_type : null; ?>
                                                        <option value="{{ $serviceType['id'] }}"
                                                            @if ($serviceType['id'] == $idServiceType) selected @endif>
                                                            {{ $serviceType['name'] }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if ($errors->has('service_type'))
                                                <span class="alert-danger">{{ $errors->first('service_type') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address Option </label>
                                            <select class="form-control address_option" name="address_option"
                                                id="address_option" style="width: 100%;">
                                                <option value=" ">Select Address Option</option>
                                                @foreach (getAddressOption() as $addressOption)
                                                    @if (old('address_option'))
                                                        <option value="{{ $addressOption['id'] }}"
                                                            {{ old('address_option') == $addressOption['id'] ? 'selected' : "'" }}>
                                                            {{ $addressOption['name'] }}
                                                        </option>
                                                    @else
                                                        <?php $idAddressOption = isset($Order) ? $Order->service_type : null; ?>
                                                        <option value="{{ $addressOption['id'] }}"
                                                            @if ($addressOption['id'] == $idAddressOption) selected @endif>
                                                            {{ $addressOption['name'] }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if ($errors->has('address_option'))
                                                <span class="alert-danger">{{ $errors->first('address_option') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Payment Method </label>
                                            <select class="form-control select2" name="payment_method"
                                                style="width: 100%;">
                                                <option value=" ">Select Payment Method</option>
                                                @foreach (getPaymentMethod() as $paymentMethod)
                                                    @if (old('payment_method'))
                                                        <option value="{{ $paymentMethod['id'] }}"
                                                            {{ old('payment_method') == $paymentMethod['id'] ? 'selected' : "'" }}>
                                                            {{ $paymentMethod['name'] }}
                                                        </option>
                                                    @else
                                                        <?php $idPaymentMethod = isset($Order) ? $Order->payment_method : null; ?>
                                                        <option value="{{ $paymentMethod['id'] }}"
                                                            @if ($paymentMethod['id'] == $idPaymentMethod) selected @endif>
                                                            {{ $paymentMethod['name'] }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if ($errors->has('payment_method'))
                                                <span class="alert-danger">{{ $errors->first('payment_method') }}</span>
                                            @endif
                                        </div>
                                    </div> --}}
                                </div>
                                {{-- <div class="row">
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
                                </div> --}}
                                <div class="pickup-address-section" style="display: none">
                                    <h6 class="heading-small text-muted mb-4">Pickup Address Section</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Pick Up Date </label>
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
                                                <label>Pick Up Time </label>
                                                <select class="form-control select2" name="pick_up_time"
                                                    id="pick_up_time" style="width: 100%;">
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
                                                <label>Pickup Location Address </label>
                                                {{-- <input type="text" name="pickup_address" id="pickup_address"> --}}
                                                <textarea style="margin-top:16px " type="text" id="pickup_address" name="pickup_address" class="form-control"> {{ isset($Order) ? $Order->pickup_address : '' }}</textarea>
                                                @if ($errors->has('pickup_address'))
                                                    <span
                                                        class="alert-danger">{{ $errors->first('pickup_address') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{-- <div class="form-group">
                                            <input type="checkbox" id="same_location" class="same_location"
                                                name="same_location" value="1">
                                            <label> Same As Drop off Address </label>
                                        </div> --}}
                                            <div class="form-group">
                                                <label>Pickup Pincode </label>
                                                <input type="number" id="pickup_pincode" name="pickup_pincode"
                                                    class="form-control"
                                                    value="{{ isset($Order) ? $Order->pickup_pincode : old('pickup_pincode') }}">
                                                @if ($errors->has('pickup_pincode'))
                                                    <span
                                                        class="alert-danger">{{ $errors->first('pickup_pincode') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="drop-address-section" style="display: none">
                                    <h6 class="heading-small text-muted mb-4">Drop Address Section</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Drop off Date</label>
                                                <input type="date" id="drop_off_date" name="drop_off_date"
                                                    class="form-control"
                                                    value="{{ isset($Order) ? $Order->drop_off_date : old('drop_off_date') }}">
                                                @if ($errors->has('drop_off_date'))
                                                    <span
                                                        class="alert-danger">{{ $errors->first('drop_off_date') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{-- <input type="checkbox" id="same_drop_off_time" class="same_drop_off_time"
                                                name="same_drop_off_time" value="1"> --}}
                                                <label>Drop off Time</label>
                                                <select class="form-control select2" id="drop_off_time"
                                                    name="drop_off_time" style="width: 100%;">
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
                                                    <span
                                                        class="alert-danger">{{ $errors->first('drop_off_time') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Drop Location Address </label>
                                                <textarea type="text" id="drop_address" name="drop_address" class="form-control"> {{ isset($Order) ? $Order->drop_address : '' }}</textarea>
                                                @if ($errors->has('drop_address'))
                                                    <span class="alert-danger">{{ $errors->first('drop_address') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Drop Pincode </label>
                                                <input type="number" id="drop_pincode" name="drop_pincode"
                                                    class="form-control"
                                                    value="{{ isset($Order) ? $Order->drop_pincode : old('drop_pincode') }}">
                                                @if ($errors->has('drop_pincode'))
                                                    <span class="alert-danger">{{ $errors->first('drop_pincode') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Service Detail </label>
                                                <textarea type="text" id="service_detail" name="service_detail" class="form-control"> {{ isset($Order) ? $Order->service_detail : '' }}</textarea>
                                                @if ($errors->has('service_detail'))
                                                    <span
                                                        class="alert-danger">{{ $errors->first('service_detail') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (isset($Order))
                                    <h6 class="heading-small text-muted mb-4">Invoice</h6>
                                    <hr />
                                    <?php if (isset($ServiceInvoice)) {
                                        $ServiceInvoice_i = count($ServiceInvoice);
                                        // print_r($ServiceInvoice_i);
                                        // exit;
                                    } ?>
                                    <input type="hidden" name="i_value" id="i_value"
                                        value="{{ isset($ServiceInvoice_i) ? $ServiceInvoice_i : 0 }}" />
                                    <table class="table table-bordered table-striped" id="dynamicTable12">
                                        <tr>
                                            <th scope="col" width="250">Invoice Date</th>
                                            <th scope="col" width="250">Invoice Amount</th>
                                            <th scope="col" width="250">Invoice Payble Amount</th>
                                            <th scope="col" width="250">Invoice Image</th>
                                            <th scope="col" width="250"></th>
                                        </tr>

                                        @if (isset($ServiceInvoice->ServiceInvoice))
                                            <?php $i = 0; ?>
                                            @foreach ($ServiceInvoice as $service_invoice)
                                                <tr>
                                                    <td>
                                                        <div class="form-group"> <input type="date"
                                                                value="{{ $service_invoice->invoice_date }}"
                                                                class="form-control"
                                                                name="addMoreInputFields[{{ $i }}][invoice_date]" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"> <input type="text"
                                                                placeholder="Enter invoice Amount"
                                                                value="{{ $service_invoice->invoice_amount }}"
                                                                class="form-control"
                                                                name="addMoreInputFields[{{ $i }}][invoice_amount]" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><input type="text"
                                                                placeholder="Enter invoice Payble Amount"
                                                                value="{{ $service_invoice->invoice_payble_amount }}"
                                                                class="form-control"
                                                                name="addMoreInputFields[{{ $i }}][invoice_payble_amount]" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group"><input type="file"
                                                                value="{{ $service_invoice->invoice_image }}"
                                                                id="fileimage" class="form-control invoiceImageUploads"
                                                                name="addMoreInputFields[{{ $i }}][invoice_image]" />
                                                            <input type="hidden" class="old_invoice_image"
                                                                value="{{ $service_invoice->invoice_image }}"
                                                                name="addMoreInputFields[{{ $i }}][old_invoice_image]" />
                                                            @if (file_exists('images/invoice_image/' . $service_invoice->invoice_image))
                                                                <span class="newinvoiceimage"> <img
                                                                        src="{{ asset('images/invoice_image') . '/' . $service_invoice->invoice_image }}"
                                                                        alt="image" class="brand-image"
                                                                        style="width:70px;hieght:70px"> </span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    @if ($i == 0)
                                                        <td><button type="button" name="add" id="add12"
                                                                class="btn btn-success">Add More</button></td>
                                                    @else
                                                        <td><button type="button"
                                                                class="btn btn-danger remove-tr">Remove</button></td>
                                                    @endif
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>
                                                    <div class="form-group"> <input type="date" class="form-control"
                                                            name="addMoreInputFields[0][invoice_date]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group"> <input type="text"
                                                            placeholder="Enter invoice Amount" class="form-control"
                                                            name="addMoreInputFields[0][invoice_amount]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group"><input type="text"
                                                            placeholder="Enter invoice Payble Amount" class="form-control"
                                                            name="addMoreInputFields[0][invoice_payble_amount]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group invoiceImageUploads"><input type="file"
                                                            class="form-control"
                                                            name="addMoreInputFields[0][invoice_image]" />
                                                    </div>
                                                    <input type="hidden" class="old_invoice_image"
                                                        name="addMoreInputFields[0][old_invoice_image]" />
                                                    <span class="newinvoiceimage"></span>
                                                </td>
                                                <td><button type="button" name="add" id="add12"
                                                        class="btn btn-success">Add More</button></td>
                                            </tr>
                                        @endif

                                        </tr>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Pick Up Images</label>
                                            <br>
                                            @if (isset($pickUpImages))
                                                @if ($pickUpImages->image1)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $pickUpImages->image1) }} "
                                                        alt="">
                                                @endif

                                                @if ($pickUpImages->image2)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $pickUpImages->image2) }} "
                                                        alt="">
                                                @endif
                                                @if ($pickUpImages->image3)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $pickUpImages->image3) }} "
                                                        alt="">
                                                @endif
                                                @if ($pickUpImages->image4)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $pickUpImages->image4) }} "
                                                        alt="">
                                                @endif
                                                @if ($pickUpImages->image5)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $pickUpImages->image5) }} "
                                                        alt="">
                                                @endif
                                                @if ($pickUpImages->image6)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $pickUpImages->image6) }} "
                                                        alt="">
                                                @endif
                                                @if ($pickUpImages->image7)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $pickUpImages->image7) }} "
                                                        alt="">
                                                @endif
                                                @if ($pickUpImages->image8)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $pickUpImages->image8) }} "
                                                        alt="">
                                                @endif
                                                @if ($pickUpImages->image9)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $pickUpImages->image9) }} "
                                                        alt="">
                                                @endif
                                                @if ($pickUpImages->image10)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $pickUpImages->image10) }} "
                                                        alt="">
                                                @endif
                                            @else
                                                <label for="">No Images</label>
                                            @endif
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            <label>Drop Off Image</label>

                                            <br>
                                            @if (isset($dropOfImages))
                                                @if ($dropOfImages->image1)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $dropOfImages->image1) }} "
                                                        alt="">
                                                @endif

                                                @if ($dropOfImages->image2)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $dropOfImages->image2) }} "
                                                        alt="">
                                                @endif
                                                @if ($dropOfImages->image3)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $dropOfImages->image3) }} "
                                                        alt="">
                                                @endif
                                                @if ($dropOfImages->image4)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $dropOfImages->image4) }} "
                                                        alt="">
                                                @endif
                                                @if ($dropOfImages->image5)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $dropOfImages->image5) }} "
                                                        alt="">
                                                @endif
                                                @if ($dropOfImages->image6)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        style="margin-top:20px; margin-bottom:15px;"
                                                        src="{{ asset('images/order_img/' . $dropOfImages->image6) }} "
                                                        alt="">
                                                @endif
                                                @if ($dropOfImages->image7)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $dropOfImages->image7) }} "
                                                        alt="">
                                                @endif
                                                @if ($dropOfImages->image8)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $dropOfImages->image8) }} "
                                                        alt="">
                                                @endif
                                                @if ($dropOfImages->image9)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $dropOfImages->image9) }} "
                                                        alt="">
                                                @endif
                                                @if ($dropOfImages->image10)
                                                    <img class="mx-2" height="150px" width="150px"
                                                        src="{{ asset('images/order_img/' . $dropOfImages->image10) }} "
                                                        alt="">
                                                @endif
                                            @else
                                                <label for="">No Images</label>
                                            @endif
                                        </div>
                                        <hr>
                                    </div>
                                @endif
                                <input name="address_value" type="hidden" id="address_value"
                                    value="{{ json_encode(getAddressOption()) }}" />
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
            $("select#address_option").change(function() {
                var get_address_option = $('#address_option').val();
                var addressoptions = $('#address_value').val();
                var addressoption = jQuery.parseJSON(addressoptions);
                var addressvalue = addressoption.filter(function(addressoption) {
                    return addressoption.id == get_address_option
                });
                if (get_address_option == addressoption[0].id) {
                    $('.pickup-address-section').show();
                    $('.drop-address-section').hide();
                }
                if (get_address_option == addressoption[1].id) {
                    $('.drop-address-section').show();
                    $('.pickup-address-section').hide();

                }
                if (get_address_option == addressoption[2].id) {
                    $('.pickup-address-section').show();
                    $('.drop-address-section').show();
                }
            });
            var addressOption = $('.address_option').find(":selected").val();
            if (addressOption) {
                var get_address_option = $('#address_option').val();
                var addressoptions = $('#address_value').val();
                var addressoption = jQuery.parseJSON(addressoptions);
                var addressvalue = addressoption.filter(function(addressoption) {
                    return addressoption.id == get_address_option
                });
                if (get_address_option == addressoption[0].id) {
                    $('.pickup-address-section').show();
                    $('.drop-address-section').hide();
                }
                if (get_address_option == addressoption[1].id) {
                    $('.drop-address-section').show();
                    $('.pickup-address-section').hide();

                }
                if (get_address_option == addressoption[2].id) {
                    $('.pickup-address-section').show();
                    $('.drop-address-section').show();
                }
            }

        });


        $(document).on("click", ".same_location", function() {
            if ($(this).prop("checked")) {
                $("#drop_address").val($('#pickup_address').val())
            }
        });
        $(document).ready(function() {


            let initializeSelect2 = function() {
                $('.js').select2();
            }

            var i_value = $('#i_value').val();
            if (i_value) {
                var i = i_value;
            } else {
                var i = 0;
            }
            $("#add12").click(function() {
                ++i;
                $("#dynamicTable12").append(
                    '<tr> <td><div class="form-group"> <input type="date" class="form-control" name="addMoreInputFields[' +
                    i +
                    '][invoice_date]" /></div></td> <td><div class="form-group"> <input type="text" class="form-control" name="addMoreInputFields[' +
                    i +
                    '][invoice_amount]" placeholder="Enter invoice Amount" /></div></td><td><div class="form-group"> <input type="text" class="form-control" name="addMoreInputFields[' +
                    i +
                    '][invoice_payble_amount]" placeholder="Enter invoice Payble Amount"/></div></td><td><div class="form-group"> <input type="file" class="form-control invoiceImageUploads" name="addMoreInputFields[' +
                    i +
                    '][invoice_image]" placeholder="Enter invoice Invoice Image"/><span class="newinvoiceimage"></span><input type="hidden" class="old_invoice_image"name="addMoreInputFields[' +
                    i +
                    '][old_invoice_image]"/></div></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>'
                );
                initializeSelect2()
            });
            $(document).on('click', '.remove-tr', function() {
                $(this).parents('tr').remove();
            });
            $(document).ready(function() {
                initializeSelect2()
            });
        });
        $('.invoiceImageUploads').on('change', function(event) {
            var form_data = new FormData();
            form_data.append("file", event.target.files[0]);
            form_data.append("_token", "{{ csrf_token() }}");
            console.log(event.target.files[0], '----------------event.target.files[0]-----------');
            //alert(formData);
            $.ajax({
                url: '{{ route('invoice-image-upload') }}',
                type: 'POST',
                data: form_data,
                success: function(data) {
                    var ImageUrl = "{{ asset('images/invoice_image') }}" + '/' + data;
                    console.log(ImageUrl, '-------------------ImageUrl------------------------');
                    var html = '<img src="' + ImageUrl + '" style="width:70px;hieght:70px">';
                    $('.newinvoiceimage').html(html);
                   // event.val(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDU3tbbU51KdyChyOBId2O3CouWtiAOn6c&callback=initAutocomplete&libraries=places&v=weekly">
    </script>
    <script type="text/javascript">
        const center = {
            lat: 50.064192,
            lng: -130.605469
        };
        // Create a bounding box with sides ~10km away from the center point
        const defaultBounds = {
            north: center.lat + 0.1,
            south: center.lat - 0.1,
            east: center.lng + 0.1,
            west: center.lng - 0.1,
        };
        const input = document.getElementById("pickup_address");
        const options = {
            bounds: defaultBounds,
            componentRestrictions: {
                country: "us"
            },
            fields: ["address_components", "geometry", "icon", "name"],
            strictBounds: false,
            types: ["establishment"],
        };
        const autocomplete = new google.maps.places.Autocomplete(input, options);
    </script>
@endsection
