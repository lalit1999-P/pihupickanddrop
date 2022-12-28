<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\LoginRequest;
use App\Http\Requests\api\SendOtpRequest;
use App\Http\Resources\LoginResource;
use Illuminate\Http\Request;
use App\Models\DailyCheck;
use App\Models\Dropoffimage;
use App\Models\Location;
use App\Models\pickanddrop;
use App\Models\Pickupimage;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;

class AuthenticateController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('contact', 'password');
        if (Auth::attempt($credentials) && auth()->user()->user_type == "2") {
            $user = auth()->user();
            if ($user->status == 0) {
                $this->response['data'] = new LoginResource($user);
                // $this->response['status'] = Response::HTTP_OK;
                $token = $user->createToken('api_token')->plainTextToken;
                $response = [
                    'user' => User::join('user_details', 'user_details.user_id', '=', 'users.id')
                        ->select('users.id as user_id', 'users.name as user_name', 'user_type', 'email', 'contact', 'user_details.*')->where('users.id', auth()->user()->id)->first(),
                    'token' => $token,
                    'status' => 200
                ];
                // $this->response['message'] = "Login sucessfully";
            } else {
                $response = [
                    'message' => 'User is Inactive',
                    'status' => 200
                ];
            }
        } else {
            $response = [
                'message' => 'User Does Not exist',
                'status' => 200
            ];
            // $this->response["message"] = "Invalid login credential";
        }

        return response($response, 200);

        // $this->status = Response::HTTP_OK;
        // return $this->returnResponse();
    }

    public function send_otp(SendOtpRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->firstOrFail();
            $otp = uniqid();

            $mailData = [
                $otp = $otp,
                $userName = $user->name,
            ];

            Mail::to($user->email)->send(new SendOtpMail($mailData));
            $user->update(['otp' => $otp]);
            $this->response["data"] = $user;
            $this->response["message"] = "Otp send successfully";
            $this->status = Response::HTTP_OK;
        } catch (Exception $e) {
            $this->response["message"] = "User Is Not Found";
        }
        return $this->returnResponse();
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
}
