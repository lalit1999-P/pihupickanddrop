<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    body {
        font-family: arial, sans-serif;
    }

    .custom-table {
        border-collapse: unset !important;
    }

    .custom-table td,
    .custom-table th {
        border: 0px;
        padding: 5px;
        text-align: left;
        background-color: transparent;
        vertical-align: top
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

<body>
    <div class="container">
        <div style="padding: 18px;">
            <table class="custom-table">
                <tr>
                    <td>
                        <h3 style="margin:0px;margin-bottom:15px;">Pihu Inc.</h3>
                        {{-- <div style="padding-bottom: 5px;">
                            1912 Harvest Lane
                        </div>
                        <div style="padding-bottom: 5px;">
                            New York, NY 12210
                        </div> --}}
                    </td>
                    <div class="text-center">
                        <img src="{{ public_path('images/pihu.png') }}"
                            style="width: 200px;height:100px;margin:0px;margin-bottom:15px;`" />
                    </div>
                    <td>
                        <h2 style="float: right;margin:0px;">INVOICE</h2>
                    </td>
                </tr>
            </table>
        </div>
        <br />
        <br />
        <br />
        <table class="custom-table">
            {{-- <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr> --}}
            <tr>
                <td style="width: 25%;">
                    <h4 style="margin:0px;margin-bottom: 15px;">Bill To</h4>
                    <div style="padding-bottom: 5px;">{{ isset($location) ? $location->location : '' }}</div>
                    <div style="padding-bottom: 5px;">{{ isset($location) ? $location->address : '' }}</div>
                    {{-- <div style="padding-bottom: 5px;white-space:nowrap;">{{ auth()->user()->email }}</div> --}}
                    {{-- <div style="padding-bottom: 5px;">{{ auth()->user()->contact }}</div> --}}
                </td>
                <td style="width: 25%; white-space:nowrap;">
                    <h4 style="margin:0px;margin-bottom: 15px;">Ship To</h4>
                    <div style="padding-bottom: 5px;">{{ $full_name ?? '' }}
                    </div>
                    <div style="padding-bottom: 5px;">{{ $pickup_address ?? '' }},
                    </div>
                    <div style="padding-bottom: 5px;">{{ $email_id ?? '' }}
                    </div>
                    <div style="padding-bottom: 5px;">{{ $mobile_no ?? '' }}
                    </div>
                </td>
                <td style="width: 50%">
                    <table style="text-align:right">
                        <tr>
                            <td>
                                <h5 style="margin: 0px 0px; width: 50%;white-space:nowrap;">Invoice #</h5>
                            </td>
                            <td>
                                <span style="margin: 0px 0px;  width: 50%;">#{{ $id ?? '' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5 style="margin: 0px 0px; width: 50%;white-space:nowrap;">Order Id</h5>
                            </td>
                            <td>
                                <span style="margin: 0px 0px;  width: 50%;">{{ $id ?? '' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5 style="margin: 0px 0px; width: 50%;white-space:nowrap;">Order Date</h5>
                            </td>
                            <td>
                                <span
                                    style="margin: 0px 0px;  width: 50%;">{{ Illuminate\Support\Carbon::parse($invoice_date)->format('d/m/Y') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5 style="margin: 0px 0px; width: 50%;white-space:nowrap;">Payment Method</h5>
                            </td>
                            <td>
                                <span style="margin: 0px 0px;  width: 50%;">
                                    @if (isset($payment_method) && $payment_method == 1)
                                        Payment on delivery
                                    @elseif (isset($payment_method) && $payment_method == 2)
                                        Online Payment
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5 style="margin: 0px 0px; width: 50%;white-space:nowrap;">Service Type</h5>
                            </td>
                            <td>
                                <span style="margin: 0px 0px;  width: 50%;">
                                    @if (isset($service_type) && $service_type == 1)
                                        Free Service
                                    @elseif (isset($service_type) && $service_type == 2)
                                        Paid Service
                                    @elseif (isset($service_type) && $service_type == 3)
                                        Accidential
                                    @endif
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div style="margin-top: 50px">
            <table bordered style="border: 1px solid #000">
                <thead>
                    <tr>
                        <th style="width: 5%;white-space:nowrap">Serial #</th>
                        <th>DESCRIPTION</th>

                        <th style="width: 25%;">AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">1</td>
                        <td> {{ $service_detail ?? '' }}</td>

                        <td style="text-align:right">
                            {{ isset($price) ? $price : 0 }}.00</td>
                    </tr>

                </tbody>
                <tbody>

                    <tr>
                        <td style="border: 1px solid transparent;"></td>
                        <td style="border-bottom: 1px solid transparent;">
                            <h4 style="text-align:right;margin:0px;">Subtotal:</h4>
                        </td>

                        <td style="text-align:right">
                            <h4 style="margin: 0px">
                                {{ isset($payble_amount) ? $payble_amount : 0 }}.00
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
                                {{ isset($payble_amount) ? $payble_amount : 0 }}.00
                            </h4>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="float: right; width:40%">
            <div style="text-align: center; margin-top:50px;font-weight:700;">
                {{ auth()->user()->name }}
            </div>
            <hr>
            <div style="text-align: center; font-weight:700;">
                <h3 style="margin: 0px">Signture</h3>
            </div>
        </div>

        <div style="margin-top: 60px;position: absolute; bottom:0px">
            <h4 style="margin-bottom: 15px;">Terms & Conditions</h4>
            <div style="margin-bottom: 25px;">Payment is due within 15 days</div>
            <div>Please make checks payable to: Pihu Inc.</div>
        </div>
    </div>
    </div>
</body>

</html>
