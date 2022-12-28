@extends('layouts.master')
@section('content')
    <style>
        body {
            font-family: arial, sans-serif;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {

            border: 1px solid #dddddd;
            text-align: left;
            padding: 10px;
        }

        tr th {
            text-align: center;
            background-color: #dddddd;
        }
    </style>
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">Service Order Invoice</h3>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('serviceorder') }}">Service Order</a></li>
                            <li class="breadcrumb-item active">Invoice</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-6 col-4 align-self-center">
                <div class="text-end upgrade-btn">
                    <a href="{{ route('generate-invoice-pdf', [request()->route('id')]) }}"
                        class="btn btn-info d-none d-md-inline-block text-white"><i class="fas fa-note"></i> Generate PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- column -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div style="padding: 18px;">
                            <div style="display: flex; justify-content: space-between">
                                <div>
                                    <h3>Pihu Inc.</h3>
                                    {{-- <div style="padding-bottom: 5px;">
                                        1912 Harvest Lane
                                    </div>
                                    <div style="padding-bottom: 5px;">
                                        New York, NY 12210
                                    </div> --}}
                                </div>
                                <div class="text-center">
                                    <img src="{{ asset('images/pihu.png') }}" style="width: 300px;height:150px" />
                                </div>
                                <div>
                                    <h2>INVOICE</h2>
                                </div>
                            </div>
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <div style="display: flex;">
                                <div style="width: 30%;">
                                    <h4 style="margin-bottom: 15px;">Bill To</h4>
                                    <div style="padding-bottom: 5px;">
                                        {{ isset($invoicedata->location) ? $invoicedata->location->location : '' }}
                                    </div>
                                    <div style="padding-bottom: 5px;">
                                        {{ isset($invoicedata->location) ? $invoicedata->location->address : '' }}</div>
                                    {{-- <div style="padding-bottom: 5px;">pihu</div>
                                    <div style="padding-bottom: 5px;">{{ auth()->user()->address }}</div>
                                    <div style="padding-bottom: 5px;">{{ auth()->user()->email }}</div>
                                    <div style="padding-bottom: 5px;"> {{ auth()->user()->contact }}</div> --}}
                                </div>
                                <div style="width: 30%;">
                                    <h4 style="margin-bottom: 15px;">Ship To</h4>
                                    <div style="padding-bottom: 5px;"> {{ $invoicedata->full_name ?? '' }}</div>
                                    <div style="padding-bottom: 5px;">{{ $invoicedata->pickup_address ?? '' }},</div>
                                    <div style="padding-bottom: 5px;">{{ $invoicedata->email_id ?? '' }}</div>
                                    <div style="padding-bottom: 5px;"> {{ $invoicedata->mobile_no ?? '' }}</div>
                                </div>
                                <div style="width: 40%; text-align: right;">
                                    <div style="display: flex;">
                                        <h5 style="margin: 10px 0px; width: 50%;">Invoice #</h5><span
                                            style="margin: 10px 0px;  width: 50%;">#{{ $invoicedata->id ?? '' }}</span>
                                    </div>
                                    <div style="display: flex;">
                                        <h5 style="margin: 10px 0px; width: 50%;">Order Id</h5><span
                                            style="margin: 10px 0px;  width: 50%;">{{ $invoicedata->id ?? '' }}</span>
                                    </div>
                                    <div style="display: flex;">
                                        <h5 style="margin: 10px 0px; width: 50%;">Order Date</h5><span
                                            style="margin: 10px 0px;  width: 50%;">{{ Illuminate\Support\Carbon::parse($invoicedata->invoice_date)->format('d/m/Y') }}</span>
                                    </div>
                                    <div style="display: flex;">
                                        <h5 style="margin: 10px 0px; width: 50%;">Payment Method</h5><span
                                            style="margin: 10px 0px;  width: 50%;">
                                            @if (isset($invoicedata->payment_method) && $invoicedata->payment_method == 1)
                                                Payment on delivery
                                            @elseif (isset($invoicedata->payment_method) && $invoicedata->payment_method == 2)
                                                Online Payment
                                            @endif
                                        </span>
                                    </div>
                                    <div style="display: flex;">
                                        <h5 style="margin: 10px 0px; width: 50%;">Service Type</h5><span
                                            style="margin: 10px 0px;  width: 50%;">
                                            @if (isset($invoicedata->service_type) && $invoicedata->service_type == 1)
                                                Free Service
                                            @elseif (isset($invoicedata->service_type) && $invoicedata->service_type == 2)
                                                Paid Service
                                            @elseif (isset($invoicedata->service_type) && $invoicedata->service_type == 3)
                                                Accidential
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 50px">
                                <table bordered style="border: 1px solid #000">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">Serial #</th>
                                            <th>DESCRIPTION</th>
                                            {{-- <th style="width: 15%;">UNIT PRICE</th> --}}
                                            <th style="width: 25%;">AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center;">1</td>
                                            <td> {{ $invoicedata->service_detail ?? '' }}</td>
                                            {{-- <td style="text-align:right">100.00</td> --}}
                                            <td style="text-align:right">
                                                {{ isset($invoicedata->price) ? $invoicedata->price : 00 }}.00</td>
                                        </tr>
                                        {{-- <tr>
                                            <td style="text-align: center;">1</td>
                                            <td>Front and brake cables</td>
                                            <td style="text-align:right">100.00</td>
                                            <td style="text-align:right">100.00</td>
                                        </tr> --}}
                                    </tbody>
                                    <tbody>

                                        <tr>
                                            <td style="border: 1px solid transparent;"></td>
                                            <td style="border-bottom: 1px solid transparent;">
                                                <h4 style="text-align:right;margin:0px;">Subtotal:</h4>
                                            </td>

                                            <td style="text-align:right">
                                                <h4 style="margin: 0px">
                                                    {{ isset($invoicedata->payble_amount) ? $invoicedata->payble_amount : 0 }}.00
                                                </h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid transparent;"></td>
                                            <td style="border-bottom: 1px solid transparent;">
                                                <h4 style="text-align:right;margin:0px;">Sales Tax:</h4>
                                            </td>

                                            <td style="text-align:right">
                                                <h4 style="margin: 0px">
                                                    0.00
                                                </h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid transparent;"></td>
                                            <td style="border-bottom: 1px solid transparent;">
                                                <h4 style="text-align:right;margin:0px;">TOTAL:</h4>
                                            </td>

                                            <td style="text-align:right;background-color: #dddddd;">
                                                <h4 style="margin: 0px">
                                                    {{ isset($invoicedata->payble_amount) ? $invoicedata->payble_amount : 0 }}.00
                                                </h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="float: right; width:30%">
                                <div style="text-align: center; margin-top:50px;font-weight:700;">
                                    {{ auth()->user()->name }}
                                </div>
                                <hr>
                                <div style="text-align: center; font-weight:700;">
                                    <h3 style="margin: 0px">Signture</h3>
                                </div>
                            </div>

                            <div style="margin-top: 250px;">
                                <h4 style="margin-bottom: 15px;">Terms & Conditions</h4>
                                <div style="margin-bottom: 25px;">Payment is due within 15 days</div>
                                <div>Please make checks payable to: Pihu Inc.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
