<?php

namespace App\Http\Requests;
use App\Model\User;
use App\Rules\AlphaSpace;
use Illuminate\Foundation\Http\FormRequest;

class PersonalInfoRequest extends FormRequest
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
    public function rules()
    {
      
        return [
            'firstname' => ['required', new AlphaSpace, 'max:40'],
            'lastname' => ['required', new AlphaSpace, 'max:40'],
            'email' => ['required', 'email', 'max:64'], 
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'min:10', 'max:5120'],
            'cellular' => ['required','min:1000000', 'max:9999999999999','numeric'], 
            'dob' => ['required'],
            'gender' => ['required'],
            'languages' => ['required'],
            'ssn' => ['required', 'numeric'],
            'position' => ['required'],
            'address' => ['required'],
            'state' => ['required'],
            'city' => ['required'],
            'start_date' => ['required'],
        ];
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
            'cellular.required' => 'Cellular cannot be empty', 
            'cellular.min'			=> 'Cellular cannot be less than 7 digits',
			'cellular.max'			=> 'Cellular cannot exceed 13 digits',
			'cellular.numeric'		=> 'Cellular should contain only numbers',
            'dob.required' => 'Birth date cannot be empty',
            'gender.required' => 'Gender cannot be empty',
            'languages.required' => 'Language cannot be empty',
            'ssn.required' => 'SSN cannot be empty',
            'ssn.numeric'		=> 'SSN should contain only numbers',
            'position.required' => 'Position cannot be empty',
            'address.required' => 'Address cannot be empty',
            'state.required' => 'State cannot be empty',
            'city.required' => 'city cannot be empty',
            'start_date.required' => 'Start Date cannot be empty',
            'influeza_vaccine_date.required' => 'Vaccine date cannot be empty',

        ];
    }
}
