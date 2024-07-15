<?php

namespace App\Http\Requests;
use App\Model\User;
use App\Rules\AlphaSpace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SaveReportRequest extends FormRequest
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
                'name' => ['required', new AlphaSpace,  'unique:reports,name,'.$request->input('id'),  'max:40'], 
                'category' => ['required'] 
            ]; 
        }else{
            return [ 
                'name' => ['required', new AlphaSpace,  'unique:reports,name',  'max:40'],
                'category' => ['required'] 
            ];
        }
    }

    public function messages()
    {
        return [ 
            'name.required' => 'Report Name cannot be empty',
            'name.alpha_spaces' => 'Report Name should contain only alphabets',
            'name.max' => 'Name cannot exceed :max characters' ,
            'category.required' => 'Category cannot be empty',               
        ];
    }
}
