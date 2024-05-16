<?php

namespace App\Http\Requests;
use App\Model\User;
use App\Rules\AlphaSpace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SaveChartCategoryRequest extends FormRequest
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
            return [ 
                'category' => ['required', new AlphaSpace,  'unique:chart_categories,name',  'max:40']  
            ]; 
    }

    public function messages()
    {
        return [ 
            'category.required' => 'Name cannot be empty',
            'category.alpha_spaces' => 'Name should contain only alphabets',
            'category.max' => 'Name cannot exceed :max characters'                
        ];
    }
}
