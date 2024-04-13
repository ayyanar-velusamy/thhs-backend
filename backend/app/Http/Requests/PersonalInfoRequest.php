<?php

namespace App\Http\Requests;

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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'	=> 'required|alpha_spaces|max:40',
            'last_name' 	=> 'required|alpha_spaces|max:40',
            'email'     	=> 'required|email|unique:users|max:64',
            'mobile'    	=> 'required|min:1000000|max:9999999999999|numeric',
            'image'     	=> 'nullable|image|mimes:jpeg,png,jpg|min:10|max:5120', 
			'roles' 		=> 'required|array',
			'roles.*' 		=> 'required',
            'status'    	=> 'required',
            'team'    		=> 'max:64',
            'department'    => 'max:64',
            'designation '  => 'max:64'
        ];
    }

    public function messages()
    {
        return [
			'first_name.required'	=> 'First Name cannot be empty',
			'first_name.alpha_spaces'=> 'First Name should contain only alphabets',
			'first_name.max'		=> 'First Name cannot exceed :max characters',
			'last_name.required'	=> 'Last Name cannot be empty',
			'last_name.alpha_spaces'=> 'Last Name should contain only alphabets',
			'last_name.max'			=> 'Last Name cannot exceed :max characters',
			'email.required'		=> 'Email ID cannot be empty',
			'email.email'			=> 'Enter a valid Email ID',
			'email.max'				=> 'Email ID cannot exceed :max characters',
			'email.unique'			=> 'Email ID already exists',
			'mobile.required'		=> 'Phone Number cannot be empty',
			'mobile.min'			=> 'Phone Number cannot be less than 7 digits',
			'mobile.max'			=> 'Phone Number cannot exceed 13 digits',
			'mobile.numeric'		=> 'Phone Number should contain only numbers',
			'roles.required'		=> 'Please choose a role name',
			'roles.*'				=> 'Please choose a role name', 
			'status.required'		=> 'Please choose a status',
			'image.mimes'			=> 'File format should accept only JPEG,PNG',
			'image.min'				=> 'Image Size must be more than 10 KB',
			'image.max'				=> 'Image Size cannot exceed 5 MB', 
			'team.max'				=> 'Team cannot exceed more than :max characters',
			'department.max'		=> 'Department cannot exceed more than :max characters',
			'designation.max'		=> 'Designation cannot exceed more than :max characters',
		];
	} 
}
