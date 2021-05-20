<?php

namespace App\Http\Requests;

use Urameshibr\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class AdminLoginRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){
        return[
            "email"=> 'required|email',
            "password" => "required|min:8",
        ];
    }

    public function messages()
    {
        return [
            "email.required" => "email field is required",
            "email.email" => "please enter a valid email",
            "password.required" => "password filed is required",
            "password.min" => "your password must be 8 characters and above"
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "success" => false,
            "error"=> $validator -> errors(),
            "message" => "One or more fields are required or not entered properly"
        ],422));
    }
}
