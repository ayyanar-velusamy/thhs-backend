<?php

namespace App\Http\Requests;
use App\Model\User;
use App\Rules\AlphaSpace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SaveChartRequest extends FormRequest
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
                'group' => ['required'],
                'name' => ['required', new AlphaSpace, 'max:40'], 
                'valid_interval' => ['required'], 
                'valid_number' => ['required'],
                'renewal_interval' => ['required'], 
                'renewal_number' => ['required'], 
                'provide_interval' => ['required'], 
                'provide_number' => ['required'], 
                'chart_handling' => ['required'] 
            ]; 
    }

    public function messages()
    {
        return [
            'group.required' => 'Group cannot be empty',
            'name.required' => 'Name cannot be empty',
            'name.alpha_spaces' => 'Name should contain only alphabets',
            'name.max' => 'Name cannot exceed :max characters', 
            'valid_interval.required' => '"Valid For Interval cannot be empty', 
            'valid_number.required' => 'Valid Interval cannot be empty',
            'valid_number.integer' => 'Valid Interval should contain only digits',
            'renewal_interval.required' => 'Renewal Interval cannot be empty', 
            'renewal_number.required' => 'Renewal Number cannot be empty',
            'renewal_number.integer' => 'Renewal Number should contain only digits',
            'provide_interval.required' => 'Provide Interval cannot be empty', 
            'provide_number.required' => 'Provide Number cannot be empty',
            'provide_number.integer' => 'Provide Number should contain only digits',
            'chart_handling.required' => 'Chart Handling cannot be empty'                 
        ];
    }
}
