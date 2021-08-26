<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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

    protected function failedValidation(Validator $validator)
    {
        $errors = implode('|', $validator->errors()->all());

        throw new HttpResponseException(
            responder()->error(422, $errors)->respond(422)
        );
    }

    public function rules()
    {
        return [
            'username' => 'required|min:3',
            'password' => 'required|min:3'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Harap masukkan username',
            'username.min'  => 'Username minimal 3 karakter',
            'password.required' => 'Harap masukkan password',
            'password.min'  => 'Password minimal 3 karakter'
        ];
    }
}
