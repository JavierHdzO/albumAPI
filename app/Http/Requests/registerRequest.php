<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class registerRequest extends FormRequest
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
            //reglas para validar los campos que llegan del request
            "name" => "required | min:3",
            "email" => "required|unique:users,email|email",
            "password" => "required | min:8",
            "passwordConfirmed" => "required | same:password"
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.min' => 'El nombre debe contener al menos 3 caracteres',
            'email.required' => 'Se requiere el email',
            'email.unique' => 'Ya existe un registro con este email',
            'password.min' => 'Se requiere introducir una contraseña de al menos 8 caracteres',
            'passwordConfirmed.same' => 'Las contraseñas no coinciden'
        ];
    }
}
