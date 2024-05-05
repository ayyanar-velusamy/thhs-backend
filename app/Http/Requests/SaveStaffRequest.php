<?php

namespace App\Http\Requests;
use App\Model\User;
use App\Rules\AlphaSpace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SaveStaffRequest extends FormRequest
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
        if($request->input('id')){
            return [
                'firstname' => ['required', new AlphaSpace, 'max:40'],
                'lastname' => ['required', new AlphaSpace, 'max:40'], 
                'submit_date' => ['required'], 
                'ssn' => ['required'],
                'gender' => ['required'], 
                'language' => ['required'], 
                'employment_type' => ['required'], 
                'organization' => ['required'], 
                'position' => ['required'] 
            ];
        }else{
            return [
                'firstname' => ['required', new AlphaSpace, 'max:40'],
                'lastname' => ['required', new AlphaSpace, 'max:40'],
                'email' => ['required', 'email', 'unique:users', 'max:64'], 
                // 'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'min:10', 'max:5120'], 
                'submit_date' => ['required'], 
                'ssn' => ['required'], 
                'gender' => ['required'], 
                'language' => ['required'], 
                'employment_type' => ['required'], 
                'organization' => ['required'], 
                'position' => ['required'] 
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
            'submit_date.required' => 'Date Hired cannot be empty', 
            'ssn.required' => 'SSN cannot be empty',
            'ssn.integer' => 'SSN should contain only digits',
            'gender.required' => 'Gender cannot be empty',
            'language.required' => 'Language cannot be empty',
            'employment_type.required' => 'Employment Type cannot be empty',
            'organization.required' => 'Organization cannot be empty',
            'position.required' => 'Position cannot be empty'          
        ];
    }
}
