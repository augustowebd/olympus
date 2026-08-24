<?php

declare(strict_types=1);

namespace App\Presentation\Http\Autenticacao\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class AutenticarArgosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'min:4',
                'max:255',
                Rule::when($this->input('username') !== 'admin', ['email']),
            ],
            'password' => [
                'required',
                'string',
                'min:4',
                'max:32',
                'regex:/\\p{L}/u',
                'regex:/\\d/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'username.min' => 'O usuário deve ter ao menos :min caracteres.',
            'username.max' => 'O usuário deve ter no máximo :max caracteres.',
            'username.email' => 'Informe o usuário admin ou um e-mail válido.',
            'password.min' => 'A senha deve ter ao menos :min caracteres.',
            'password.max' => 'A senha deve ter no máximo :max caracteres.',
            'password.regex' => 'A senha deve conter ao menos uma letra e um número.',
        ];
    }
}
