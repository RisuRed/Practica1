<?php

namespace App\Http\Requests;

use App\Rules\EmailValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRules;

class RegistroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email'=> ['required', new EmailValidation(), 'unique:users,email'],
            'password'=>[
                'required',
                PasswordRules::min(8)->letters()->symbols()->numbers()
            ]
        ];
    }
    public function messages(){
        return [
            'name' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email no es valido',
            'email.unique' => 'Email en uso',
            'password' => 'El password debe contener almenos 8 caracteres, un simbolo y un numero',
        ];
    }
}
