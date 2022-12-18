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
            <div style="display: flex; justify-content: space-between">
                <div>
                    <h3>Pihu Inc.</h3>
                    <div style="padding-bottom: 5px;">
                        1912 Harvest Lane
                    </div>
                    <div style="padding-bottom: 5px;">
                        New York, NY 12210
                    </div>
                </div>
                <div>
                    <h2>INVOICE</h2>
                </div>
            </div>
            <br />
            <br />
            <br />
            <div style="display: flex;">
                <div style="width: 30%;">
                    <h4 style="margin-bottom: 15px;">Bill To</h4>
                    <div style="padding-bottom: 5px;">pihu</div>
                    <div style="padding-bottom: 5px;">{{ auth()->user()->address }}</div>
                    <div style="padding-bottom: 5px;">Email :{{ auth()->user()->email }}</div>
                    <div style="padding-bottom: 5px;">Contact : {{ auth()->user()->contact }}</div>
                </div>
                <div style="width: 30%;">
                    <h4 style="margin-bottom: 15px;">Ship To</h4>
                    <div style="padding-bottom: 5px;">Name : {{ $full_name ?? '' }}
                    </div>
                    <div style="padding-bottom: 5px;">{{ $pickup_address ?? '' }},
                    </div>
                    <div style="padding-bottom: 5px;">Email :{{ $email_id ?? '' }}
                    </div>
                    <div style="padding-bottom: 5px;">Contact : {{ $mobile_no ?? '' }}
                    </div>
                </div>
                <div style="width: 40%; text-align: right;">
                    <div style="display: flex;">
                        <h5 style="margin: 10px 0px; width: 50%;">Invoice #</h5><span
                            style="margin: 10px 0px;  width: 50%;">#6</span>
                    </div>
                    <div style="display: flex;">
                        <h5 style="margin: 10px 0px; width: 50%;">Order Id</h5><span
                            style="margin: 10px 0px;  width: 50%;">{{ $id ?? '' }}</span>
                    </div>
                    <div style="display: flex;">
                        <h5 style="margin: 10px 0px; width: 50%;">Order Date</h5><span
                            style="margin: 10px 0px;  width: 50%;">{{ Illuminate\Support\Carbon::parse($invoice_date)->format('d/m/Y') }}</span>
                    </div>
                    <div style="display: flex;">
                        <h5 style="margin: 10px 0px; width: 50%;">Payment Method</h5><span
                            style="margin: 10px 0px;  width: 50%;">
                            @if (isset($payment_method) && $payment_method == 1)
                                Payment on delivery
                            @elseif (isset($payment_method) && $payment_method == 2)
                                Online Payment
                            @endif
                        </span>
                    </div>
                    <div style="display: flex;">
                        <h5 style="margin: 10px 0px; width: 50%;">Service Type</h5><span
                            style="margin: 10px 0px;  width: 50%;">
                            @if (isset($service_type) && $service_type == 1)
                                Free Service
                            @elseif (isset($service_type) && $service_type == 2)
                                Paid Service
                            @elseif (isset($service_type) && $service_type == 3)
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

                            <th style="width: 25%;">AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center;">1</td>
                            <td> {{ $service_detail ?? '' }}</td>

                            <td style="text-align:right">
                                {{ isset($price) ? $price : 00 }}</td>
                        </tr>

                    </tbody>
                    <tbody>

                        <tr>
                            <td style="border: 1px solid transparent;"></td>
                            <td style="border-bottom: 1px solid transparent;"></td>

                            <td style="text-align:right">
                                <h4 style="margin-bottom: 0px"> Total Payble:
                                    {{ isset($payble_amount) ? $payble_amount : 00 }}
                                </h4>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="float: right; margin-top:15px">
                {{ auth()->user()->name }}
            </div>
            <div style="margin-top: 60px;">
                <h4 style="margin-bottom: 15px;">Terms & Conditions</h4>
                <div style="margin-bottom: 25px;">Payment is due within 15 days</div>
                <div>Please make checks payable to: Pihu Inc.</div>
            </div>
        </div>
    </div>
</body>

</html>
