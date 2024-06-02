<?php

namespace App\Http\Requests;

use App\Model\User;
use App\Rules\AlphaSpace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UploadDocumentRequest extends FormRequest
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
                'chart_id' => ['required'],
                'document' => ['required']
                
            ];
 
    }

    public function messages()
    {
        return [ 
            'chart_id.required' => 'Chart Id cannot be empty', 
            'document.required' => 'Document cannot be empty' 

        ];
    }
}
