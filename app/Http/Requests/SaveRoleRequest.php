<?php

namespace App\Http\Requests;
use App\Model\User;
use App\Rules\AlphaSpace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SaveRoleRequest extends FormRequest
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
                'role' => ['required', new AlphaSpace,  'unique:user_roles,role,'.$request->input('id'),  'max:40'],  
                'status' => ['required'],
            ]; 
        }else{
            return [ 
                'role' => ['required', new AlphaSpace,  'unique:user_roles,role',  'max:40'],  
                'status' => ['required'],
            ];
        }
    }

    public function messages()
    {
        return [ 
            'role.required' => 'Role Name cannot be empty',
            'role.alpha_spaces' => 'Role Name should contain only alphabets',
            'role.max' => 'Role Name cannot exceed :max characters', 
            'status.required' => 'Status cannot be empty'         
        ];
    }
}
