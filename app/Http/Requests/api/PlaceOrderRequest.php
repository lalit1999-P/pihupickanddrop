<?php

namespace App\Http\Requests\api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class PlaceOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'reg_number' => 'required|max:20',
            'mobile_no'     => 'required|digits:10|numeric',
            'vehicle_model' => 'required',
            'vehicle_variant'     => 'required',
            'first_name'     => 'required|max:50|regex:/^[a-zA-Z\s]+$/',
            'last_name'     => 'required|max:50|regex:/^[a-zA-Z\s]+$/',
            'sur_name'     => 'required|max:50|regex:/^[a-zA-Z\s]+$/',
            'email_id'     => 'required|email|email:rfc,dns',
            'address'     => 'required|max:250',
            'houser_no'     => 'nullable',
            'street_name'     => 'nullable|max:60',
            'landmark'     => 'nullable',
            'service_date'     => 'nullable|date',
            'service_detail'     => 'nullable|max:250',
            'price'     => 'nullable|regex:/^[0-9.]+$/',
            'pick_up_date'     => 'nullable',
            'pick_up_time'     => 'nullable',
            'drop_off_date'     => 'nullable',
            'drop_off_time'     => 'nullable',

        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(["data" => null, "message" => $validator->errors()->first()], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
