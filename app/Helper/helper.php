<?php

use App\Models\User;

function fileUpload($path, $image)
{
    $imageName = time() . mt_rand(1, 50000) . '.' . $image->extension();
    $image->move(public_path('images/' . $path), $imageName);
    return  $imageName;
}

function fieldRequired()
{
    return "<span style='color:red'> * </span>";
}

function timeSlot()
{
    return [
        "08-09 AM",
        "09-10 AM",
        "10-11 AM",
        "11-12 AM",
        "12-01 PM",
        "01-02 PM",
        "02-03 PM",
        "03-04 PM",
        "04-05 PM",
        "05-06 PM",
        "06-07 PM",
        "07-08 PM",
    ];
}
function getAdminList()
{
    $User = User::where('user_type', 2)->get();
    return $User;
}
function getServiceType()
{
    return [
        [
            'id' => 1,
            'name' => 'Free Service'
        ],
        [
            'id' => 2,
            'name' => 'Paid Service'
        ], [
            'id' => 3,
            'name' => 'Accidential'
        ], [
            'id' => 4,
            'name' => 'Running Repair'
        ], [
            'id' => 5,
            'name' => 'Used Car Pickup'
        ], [
            'id' => 6,
            'name' => 'New Vehicle Pickup'
        ]
    ];
}
function getPaymentMethod()
{
    return [
        [
            'id' => 1,
            'name' => 'Payment on delivery'
        ],
        [
            'id' => 2,
            'name' => 'Online Payment'
        ]
    ];
}
function getAddressOption()
{
    return [
        [
            'id' => 1,
            'name' => 'Pickup'
        ],
        [
            'id' => 2,
            'name' => 'Drop'
        ],
        [
            'id' => 3,
            'name' => 'Both'
        ]
    ];
}
function searchForAddressOption($id, $array)
{
    foreach ($array as $key => $val) {
        if ($val['id'] === $id) {
            return $val;
        }
    }
    return null;
}
function smsGateWay($param)
{
    $mobile=$param['mobileList'];
    $message=$param['message'];
    $apikey='';
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.smsgateway.center/SMSApi/rest/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'senderId=SMSGAT&sendMethod=simpleMsg&msgType=text&mobile=$mobile&msg=$message&duplicateCheck=true&format=json',
        CURLOPT_HTTPHEADER => array(
            'apiKey:'.$apikey,
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
}
