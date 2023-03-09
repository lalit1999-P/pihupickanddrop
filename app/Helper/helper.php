<?php

use App\Models\User;
use App\sms\psmplSMSGatewayCenter;

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
    $Username = \Config::get('configvalue.SMSGETWAY_USERNAME');
    $Password = \Config::get('configvalue.SMSGETWAY_PASSWORD');
    $smsgatewaycenter = new psmplSMSGatewayCenter($Username, $Password); //Your username and password
    $smsgatewaycenter->setMobile($param['mobileList']); //Your recipient mobile number
    $smsgatewaycenter->setMsg($param['message']); // Your message
    $smsgatewaycenter->setMsgType(psmplSMSGatewayCenter::MSG_TYPE_TEXT); //Change to MSG_TYPE_UNICODE for Unicode message
    $smsgatewaycenter->setSenderId("SMSGAT"); // Your approved sender anem
    $smsgatewaycenter->setSendMethod(psmplSMSGatewayCenter::METHOD_SIMPLE_MSG);
    $smsgatewaycenter->setTestMessage("false"); //set this to true to test
    $smsgatewaycenter->sendSMS(psmplSMSGatewayCenter::SMSAPI, 'send');
    return $smsgatewaycenter->getResponse();
}
