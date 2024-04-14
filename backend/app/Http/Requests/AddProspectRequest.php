<?php

namespace App\Http\Requests;
use App\Model\User;
use App\Rules\AlphaSpace;
use Illuminate\Foundation\Http\FormRequest;

class AddProspectRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:users', 'max:64'], 
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'min:10', 'max:5120'], 
            'dob' => ['required'], 
            'position' => ['required'] 
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
            'dob.required' => 'Birth Date cannot be empty', 
            'position.required' => 'Position cannot be empty'
          
        ];
    }
}
