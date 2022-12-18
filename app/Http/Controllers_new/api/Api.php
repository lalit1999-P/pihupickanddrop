<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DailyCheck;
use App\Models\Dropoffimage;
use App\Models\Location;
use App\Models\pickanddrop;
use App\Models\Pickupimage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Api extends Controller
{
    public function driver_orders(Request $request)
    {
        if (!auth()->user()) {
            return response()->json([
                'message' => 'Invalid Token',
                'status' => 403
            ], 200);
        }
        $order = pickanddrop::join('vehicle_model', 'pickanddrop.vehicle_model', '=', 'vehicle_model.id')->join('vehicle_variant', 'pickanddrop.vehicle_variant', '=', 'vehicle_variant.id')->join('syclist', 'pickanddrop.svc_list', '=', 'syclist.id')->join('users', 'pickanddrop.service_advisor', '=', 'users.id')
            ->join('service_type', 'pickanddrop.service_type', '=', 'service_type.id')
            ->select('pickanddrop.*', 'vehicle_model.vehicle_model as vehicle_model', 'vehicle_variant.vehicle_variant as vehicle_variant', 'syclist.syc as syc_list', 'users.name as service_advisor', 'service_type.service_type as service_type')
            ->where('pickanddrop.driver_id', auth()->user()->id)->get();
        if (count($order) > 0) {
            foreach ($order as $ord) {

                $Dropoffimage = Dropoffimage::where('driver_id', auth()->user()->id)->where('order_id', $ord->id)->first();
                if (isset($Dropoffimage)) {
                    if (isset($Dropoffimage->image1)) {

                        $ord->Dropoffimage1 = 'https://pihu.alpinetechnologies.eu/public/drop_image/' . $Dropoffimage->image1;
                    } else {
                        $ord->Dropoffimage1 = NULL;
                    }
                    if (isset($Dropoffimage->image2)) {
                        $ord->Dropoffimage2 = 'https://pihu.alpinetechnologies.eu/public/drop_image/' . $Dropoffimage->image2;
                    } else {
                        $ord->Dropoffimage2 = NULL;
                    }
                    if (isset($Dropoffimage->image3)) {
                        $ord->Dropoffimage3 = 'https://pihu.alpinetechnologies.eu/public/drop_image/' . $Dropoffimage->image3;
                    } else {
                        $ord->Dropoffimage3 = NULL;
                    }
                    if (isset($Dropoffimage->image4)) {
                        $ord->Dropoffimage4 = 'https://pihu.alpinetechnologies.eu/public/drop_image/' . $Dropoffimage->image4;
                    } else {
                        $ord->Dropoffimage4 = NULL;
                    }
                    if (isset($Dropoffimage->image5)) {
                        $ord->Dropoffimage5 = 'https://pihu.alpinetechnologies.eu/public/drop_image/' . $Dropoffimage->image5;
                    } else {
                        $ord->Dropoffimage5 = NULL;
                    }
                }
                $Pickupimage = Pickupimage::where('driver_id', auth()->user()->id)->where('order_id', $ord->id)->first();
                if (isset($Pickupimage)) {
                    if (isset($Pickupimage->image1)) {
                        $ord->Pickupimage1 = 'https://pihu.alpinetechnologies.eu/public/drop_image/' . $Pickupimage->image1;
                    } else {
                        $ord->Pickupimage1 = NULL;
                    }
                    if (isset($Pickupimage->image2)) {
                        $ord->Pickupimage2 = 'https://pihu.alpinetechnologies.eu/public/drop_image/' . $Pickupimage->image2;
                    } else {
                        $ord->Pickupimage2 = NULL;
                    }
                    if (isset($Pickupimage->image3)) {
                        $ord->Pickupimage3 = 'https://pihu.alpinetechnologies.eu/public/drop_image/' . $Pickupimage->image3;
                    } else {
                        $ord->Pickupimage3 = NULL;
                    }
                    if (isset($Pickupimage->image4)) {
                        $ord->Pickupimage4 = 'https://pihu.alpinetechnologies.eu/public/drop_image/' . $Pickupimage->image4;
                    } else {
                        $ord->Pickupimage4 = NULL;
                    }
                    if (isset($Pickupimage->image5)) {
                        $ord->Pickupimage5 = 'https://pihu.alpinetechnologies.eu/public/drop_image/' . $Pickupimage->image5;
                    } else {
                        $ord->Pickupimage5 = NULL;
                    }
                }
            }
            $message = "Driver's Order.";
            $response = [
                'message' => $message,
                'order' => $order,
                'status' => 200
            ];
        } else {
            $message = "No Order Found";
            $response = [
                'message' => $message,
                'status' => 200
            ];
        }
        return response($response, 200);
    }

   


   
   
   
  
    public function dropoff_image(Request $request)
    {
        if (!auth()->user()) {
            return response()->json([
                'message' => 'Invalid Token',
                'status' => 403
            ], 200);
        }
        $validator = Validator::make($request->all(), [
            'image1' => "required",
            'order_id' => "required",

        ]);

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'status' => 403

            ];
            return response($response, 200);
        }
        if ($request->hasFile('image1')) {
            $image1 = $request->file('image1');
            $file1 = $image1;
            $extension1 = $file1->getClientOriginalExtension();
            $filename1 = uniqid() . '.' . $extension1;
            $file1->move('public/drop_image', $filename1);
        } else {
            $filename1 = '';
        }
        if ($request->hasFile('image2')) {
            $image2 = $request->file('image2');
            $file2 = $image2;
            $extension2 = $file2->getClientOriginalExtension();
            $filename2 = uniqid() . '.' . $extension2;
            $file2->move('public/drop_image', $filename2);
        } else {
            $filename2 = '';
        }
        if ($request->hasFile('image3')) {
            $image3 = $request->file('image3');
            $file3 = $image3;
            $extension3 = $file3->getClientOriginalExtension();
            $filename3 = uniqid() . '.' . $extension3;
            $file3->move('public/drop_image', $filename3);
        } else {
            $filename3 = '';
        }
        if ($request->hasFile('image4')) {
            $image4 = $request->file('image4');
            $file4 = $image4;
            $extension4 = $file4->getClientOriginalExtension();
            $filename4 = uniqid() . '.' . $extension4;
            $file4->move('public/drop_image', $filename4);
        } else {
            $filename4 = '';
        }
        if ($request->hasFile('image5')) {
            $image5 = $request->file('image5');
            $file5 = $image5;
            $extension5 = $file5->getClientOriginalExtension();
            $filename5 = uniqid() . '.' . $extension5;
            $file5->move('public/drop_image', $filename5);
        } else {
            $filename5 = '';
        }
        $usersave = new Dropoffimage();
        $usersave->image1 = $filename1;
        $usersave->image2 = $filename2;
        $usersave->image3 = $filename3;
        $usersave->image4 = $filename4;
        $usersave->image5 = $filename5;
        $usersave->order_id = $request->order_id;
        $usersave->driver_id = auth()->user()->id;
        $usersave->save();
        $message = "Saved Successfully.";
        $response = [
            'message' => $message,

            'status' => 200
        ];
        return response($response, 200);
    }

   
   
}
