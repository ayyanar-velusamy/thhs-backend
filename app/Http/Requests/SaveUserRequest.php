<?php

namespace App\Http\Requests;

use App\Model\User;
use App\Rules\AlphaSpace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SaveUserRequest extends FormRequest
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
     * @return array
     */
    public function rules(Request $request)
    {

        if ($request->input('id')) {
            return [
                'firstname' => ['required', new AlphaSpace, 'max:40'],
                'lastname' => ['required', new AlphaSpace, 'max:40'],
                'email' => ['required', 'email', 'unique:users,email,' . $request->input('id'), 'max:64'],
                // 'account_expire_date' => ['required'],
                // 'password_expire_date' => ['required'],
                'status' => ['required'],
                'phone_number' => ['required'],
            ];
        } else {
            return [
                'firstname' => ['required', new AlphaSpace, 'max:40'],
                'lastname' => ['required', new AlphaSpace, 'max:40'],
                'email' => ['required', 'email', 'unique:users,email', 'max:64'],
                // 'account_expire_date' => ['required'],
                // 'password_expire_date' => ['required'],
                'status' => ['required'],
                'phone_number' => ['required'],
            ];
        }
    }

    public function messages()
    {
        return [
            'firstname.required' => 'First Name cannot be empty',
            'firstname.alpha_spaces' => 'First Name should contain only alphabets',
            'firstname.max' => 'First Name cannot exceed :max characters',
            'lastname.required' => 'Last Name cannot be empty',
            'lastname.alpha_spaces' => 'Last Name should contain only alphabets',
            'lastname.max' => 'Last Name cannot exceed :max characters',
            'email.required' => 'Email ID cannot be empty',
            'email.email' => 'Enter a valid Email ID',
            'email.max' => 'Email ID cannot exceed :max characters',
            'email.unique' => 'Email ID already exists',
            'password_expire_date.required' => 'Password Expire Date cannot be empty',
            'account_expire_date.required' => 'Account Expire Date cannot be empty',
            'status.required' => 'Status cannot be empty',
            'phone_number.required' => 'Cellular cannot be empty',
            'phone_number.min' => 'Cellular cannot be less than 7 digits',
            'phone_number.max' => 'Cellular cannot exceed 13 digits',
            'phone_number.numeric' => 'Cellular should contain only numbers',

        ];
    }
}
