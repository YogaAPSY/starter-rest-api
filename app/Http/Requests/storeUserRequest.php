<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class storeUserRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = implode('|', $validator->errors()->all());

        throw new HttpResponseException(
            responder()->error(422, $errors)->respond(422)
        );
    }
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
    public function rules()
    {
        return [
            'username' => 'required|min:3|unique:users,username',
            'password' => 'required|min:3',
            'name'     => 'required|min:3',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Harap masukkan username',
            'username.min'  => 'Username minimal 3 karakter',
            'username.unique' => 'Username yang ada masukkan sudah ada',
            'password.required' => 'Harap masukkan password',
            'password.min'  => 'Password minimal 3 karakter',
            'name.required' => 'Harap masukkan nama',
            'name.min'      => 'Nama minimal 3 karakter'
        ];
    }
}
