<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Location;
use App\Models\DailyCheck;
use App\Models\pickndrop;
use App\Models\pickanddrop;
use App\Models\Pickupimage;
use App\Models\Dropoffimage;
use App\Models\Order;
use App\Models\OrderImage;
use App\Models\Syclist;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;

class Api extends Controller
{
    public function login(Request $request)
    {
        $content = json_decode($request->getContent());

        $validator = Validator::make($request->json()->all(), [
            'user_id' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'status' => 403

            ];
            return response($response, 200);
        }
        $userdata = array(
            'email' => $content->user_id,
            'password' => $content->password,
        );
        if (Auth::attempt($userdata)) {
            $token = auth()->user()->createToken('API Token')->accessToken;
            $response = [
                'user' => User::join('user_details', 'user_details.user_id', '=', 'users.id')
                    ->select('users.id as user_id', 'users.name as user_name', 'user_type', 'email', 'contact', 'user_details.*')->where('users.id', auth()->user()->id)->first(),
                'token' => $token,
                'status' => 200
            ];
        } else {
            $response = [
                'message' => 'User Does Not exist',
                'status' => 200
            ];
        }

        return response($response, 200);
    }
    public function locations(Request $request)
    {

        if (!auth()->user()) {
            return response()->json([
                'message' => 'Invalid Token',
                'status' => 403
            ], 200);
        }

        $location = Location::select('id', 'location')->get();
        $message = 'Locations available';
        $response = [
            'message' => $message,
            'location' => $location,
            'status' => 200
        ];
        return response($response, 200);
    }

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

    public function update_user_profile(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'email' => [
                'string',
                'email',
                'max:255',
                // 'regex:/^\w+[-\.\w]*@(?!(?:outlook|myemail|yahoo)\.com$)\w+[-\.\w]*?\.\w{2,4}$/'
            ],
            'contact' =>  ['required', 'digits:10'],

        ]);


        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'status' => 403
            ];
            return response($response, 200);
        }

        $content = json_decode($request->getContent());
        $usersave = User::find(auth()->user()->id);
        $usersave->name = $content->name;
        $usersave->email = $content->email;
        $usersave->contact = $content->contact;
        $usersave->address = $content->address;
        $usersave->save();

        $message = "Profile Updated Successfully.";
        $response = [
            'message' => $message,
            'user' => $usersave,
            'status' => 200
        ];
        return response($response, 200);
    }

    public function order_payment_status(Request $request)
    {
        if (!auth()->user()) {
            return response()->json([
                'message' => 'Invalid Token',
                'status' => 403
            ], 200);
        }
        $validator = Validator::make($request->all(), [
            'payment_method' => "required",
            'payble_amount' => "required",
            'order_id' => "required"

        ]);

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'status' => 403

            ];
            return response($response, 200);
        }

        $Order = Order::find($request->order_id);
        $Order->payment_method = $request->payment_method;
        $Order->payble_amount = $request->payble_amount;
        $Order->action_status = 2;
        $Order->save();
        $response = [
            'message' => "Order Payment Status Changed successfully",
            'status' => 200
        ];
        return response($response, 200);
    }
    public function view_profile(Request $request)
    {
        if (!auth()->user()) {
            return response()->json([
                'message' => 'Invalid Token',
                'status' => 403
            ], 200);
        }
        $user  = User::join('user_details', 'user_details.user_id', '=', 'users.id')
            ->select('users.id as user_id', 'users.name as user_name', 'user_type', 'users.address as address', 'email', 'contact', 'user_details.*')->where('users.id', auth()->user()->id)->first();
        $message = "User Details";
        $response = [
            'message' => $message,
            'user' => $user,
            'status' => 200
        ];
        return response($response, 200);
    }
    public function changePassword(Request $request)
    {
        if (!auth()->user()) {
            return response()->json([
                'message' => 'Invalid Token',
                'status' => 403
            ], 200);
        }
        $validator = Validator::make($request->json()->all(), [
            'old_password' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required_with:password|same:password|min:6'
        ]);

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'status' => 403

            ];
            return response($response, 200);
        }
        $user = auth()->user();
        $content = json_decode($request->getContent());
        if (!Hash::check($content->old_password, auth()->user()->password)) {
            return response()->json(['message' => 'The specified password does not match the database password', 'status' => Response::HTTP_UNAUTHORIZED], 401);
        } else {
            $user->fill([
                'password' => Hash::make($content->password)
            ])->save();
            return response()->json(['message' => 'Password changed successfully', 'status' => Response::HTTP_OK], 200);
        }
    }
    public function send_otp(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'email' => "required|email",
        ]);

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'status' => 403

            ];
            return response($response, 200);
        }
        $content = json_decode($request->getContent());
        $user = User::where('email', $content->email)->first();
        $otp = uniqid();
        $user = $user->update(['otp' => $otp]);

        if ($user) {
            $mail_details =  'Your OTP is : ' . $otp;
            $email = $content->email;
            $headers = "From: jagritivalecha25@gmail.com\r\n";
            $headers .= "Reply-To: jagritivalecha25@gmail.com\r\n";
            $headers .= "Return-Path:jagritivalecha25@gmail.com\r\n";
            $headers .= "CC: jagritivalecha25@gmail.com\r\n";
            $headers .= "BCC: jagritivalecha25@gmail.com\r\n";
            mail($email, "Loader OTP Verification", $mail_details, $headers);


            $message = 'Mail sent successfully';
            $response = ['message' => $message];
            return response()->json(['result' => $response, 'status' => Response::HTTP_OK], 200);
        } else {
            $message = 'User not Found';
            $response = ['message' => $message];
            return response()->json(['result' => $response, 'status' => Response::HTTP_OK], 200);
        }
    }
    public function verify_mail_otp(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'email' => "required|email",
            'otp' => "required",
        ]);

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'status' => 403

            ];
            return response($response, 200);
        }
        $content = json_decode($request->getContent());
        $user = User::where('email', $content->email)->where('otp', $content->otp)->first();
        if ($user) {
            $user1 = User::where('email', $content->email)->update(['otp' => '']);

            $token = $user->createToken('API Token')->accessToken;
            return response()->json(['token' => $token, 'message' => 'OTP Verified Successfully', 'status' => Response::HTTP_OK], 200);
        } else {
            return response()->json(['message' => 'Invalid OTP', 'status' => Response::HTTP_NOT_FOUND], 200);
        }
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'email' => "required|email",
            'password' => "required",
        ]);

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'status' => 403

            ];
            return response($response, 200);
        }
        $content = json_decode($request->getContent());
        $user = User::where('email', $content->email)->first();
        if ($user) {
            $user1 = User::where('email', $content->email)->update(['password' => Hash::make($content->password)]);

            return response()->json(['message' => 'Password Changed Succuessfully', 'user' => $user, 'status' => Response::HTTP_OK], 200);
        } else {
            return response()->json(['message' => 'Invalid OTP', 'status' => Response::HTTP_NOT_FOUND], 200);
        }
    }
    public function daily_check(Request $request)
    {
        if (!auth()->user()) {
            return response()->json([
                'message' => 'Invalid Token',
                'status' => 403
            ], 200);
        }
        $validator = Validator::make($request->json()->all(), [
            'date' => "required",

        ]);

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'status' => 403

            ];
            return response($response, 200);
        }
        $content = json_decode($request->getContent());
        $daily_check = new DailyCheck();
        $daily_check->user_id = auth()->user()->id;
        $daily_check->date = $content->date;
        $daily_check->shower = $content->shower;
        $daily_check->charger = $content->charger;
        $daily_check->power_bank = $content->power_bank;
        $daily_check->uniform     = $content->uniform;
        $daily_check->perfume = $content->perfume;
        $daily_check->pen = $content->pen;
        $daily_check->swaping_machine = $content->swaping_machine;
        $daily_check->qr_code = $content->qr_code;
        $daily_check->id_card = $content->id_card;
        $daily_check->clean_shave = $content->clean_shave;

        $daily_check->save();
        $message = "Saved Successfully.";
        $response = [
            'message' => $message,
            'dailyCheck' => $daily_check,
            'status' => 200
        ];
        return response($response, 200);
    }

    public function dropoff_image(Request $request)
    {
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
            $filename1 = fileUpload('order_img',  $request->file('image1'));
        } else {
            $filename1 = '';
        }
        if ($request->hasFile('image2')) {
            $filename2 = fileUpload('order_img',  $request->file('image2'));
        } else {
            $filename2 = '';
        }
        if ($request->hasFile('image3')) {
            $filename3 = fileUpload('order_img',  $request->file('image3'));
        } else {
            $filename3 = '';
        }
        if ($request->hasFile('image4')) {
            $filename4 = fileUpload('order_img',  $request->file('image4'));
        } else {
            $filename4 = '';
        }
        if ($request->hasFile('image5')) {
            $filename5 = fileUpload('order_img',  $request->file('image5'));
        } else {
            $filename5 = '';
        }

        Order::where('id', $request->order_id)->update(["assign_status" => "3","action_status" => 3]);

        Dropoffimage::updateOrCreate(
            ["order_id" => $request->order_id, "driver_id" => auth()->user()->id],
            [
                "image1" => $filename1,
                "image2" => $filename2,
                "image3" => $filename3,
                "image4" => $filename4,
                "image5" => $filename5,
            ]
        );
        $message = "Saved Successfully.";
        $response = [
            'message' => $message,
            'status' => 200
        ];
        return response($response, 200);
    }

    public function pickup_image(Request $request)
    {
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
            $filename1 = fileUpload('order_img',  $request->file('image1'));
        } else {
            $filename1 = '';
        }
        if ($request->hasFile('image2')) {
            $filename2 = fileUpload('order_img',  $request->file('image2'));
        } else {
            $filename2 = '';
        }
        if ($request->hasFile('image3')) {
            $filename3 = fileUpload('order_img',  $request->file('image3'));
        } else {
            $filename3 = '';
        }
        if ($request->hasFile('image4')) {
            $filename4 = fileUpload('order_img',  $request->file('image4'));
        } else {
            $filename4 = '';
        }
        if ($request->hasFile('image5')) {
            $filename5 = fileUpload('order_img',  $request->file('image5'));
        } else {
            $filename5 = '';
        }

        Pickupimage::updateOrCreate(
            ["order_id" => $request->order_id, "driver_id" => auth()->user()->id],
            [
                "image1" => $filename1,
                "image2" => $filename2,
                "image3" => $filename3,
                "image4" => $filename4,
                "image5" => $filename5,
            ]
        );
        
        Order::where('id', $request->order_id)->update(["action_status" => 1]);
        $message = "Saved Successfully.";
        $response = [
            'message' => $message,
            'status' => 200
        ];
        return response($response, 200);
    }
    public function changeorderstatus(Request $request)
    {
        // dd("hii");
        $validator = Validator::make($request->all(), [
            'order_id' => "required",
            'assign_status' => 'required|in:accept,reject',
        ]);

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'status' => 403
            ];
            return response($response, 200);
        }

        //condition for check  accepted and rejected .
        $message = "";
        $orderData = Order::where('id', $request->order_id)->first();
        // dd($orderData);
        if ($orderData) {
            // dd($orderData);
            if ($request->assign_status ==  'accept') {
                $orderData->update(['assign_status' => 2]);
                $message = "Order status accepted successfully.";
            } else {
                //this called when reject
                $orderData->update(['assign_status' => 1, "driver_id" => null]);
                $message = "Order Status rejected";
            }
        } else {
            $message = "There is no any orders.";
        }


        $response = [
            'message' => $message,
            'status' => 200
        ];
        return response($response, 200);
    }
}
