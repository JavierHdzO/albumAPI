<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhotoRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type' => [
                'nullable',
                'string'
            ],
            'status' => [
                'nullable',
                'string'
            ],
            'schedule' => [
                'nullable',
                'date',
                'date_format:Y-m-d H:i:s'
            ]
        ];
    }

    
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, mixed>
     */
    public function messages(){
        return [
            'type.string' => 'Type must be a string',
        ];
    }
}
