<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rules\File;

class StorePhotoRequest extends FormRequest
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
                'required',
                'max:20'
                
            ],
            'status' => [
                'nullable',
                'max:20'
            ],
            'photo' => [
                'required',
                'mimes:png,jpg,jpeg'
            ],
            'schedule' => [
                'nullable',
                'date_format:Y-m-d H:i:s'
            ],
            

        ];
    }
}
