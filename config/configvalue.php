<?php
return [

    'GOOGLE_API_KEY' => env('GOOGLE_API_KEY', null),
    'SMSGETWAY_USERNAME' => env('SMSGETWAY_USERNAME', null),
    'SMSGETWAY_PASSWORD' => env('SMSGETWAY_PASSWORD', null),
    'SMSGETWAY_API_KEY' => env('SMSGETWAY_API_KEY', null),
    'ORDER_ACTION_STATUS'=>[
        'PICKUP_IMAGE' =>1,
        'DROP_IMAGE_SERVICE_CENTER'=>2,
        'PICKUP_IMAGE_SERVICE_CENTER'=>3,
        'DROP_IMAGE' =>4,
        'PAYMENT'=>5
    ]

];
