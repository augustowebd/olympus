<?php

declare(strict_types=1);

namespace App\Presentation\Http\Pessoas\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class EnderecoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cep' => ['required', 'string'],
            'logradouro' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'string', 'max:255'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'bairro' => ['required', 'string', 'max:255'],
            'pais_uuid' => ['required', 'uuid'],
            'uf_uuid' => ['required', 'uuid'],
            'cidade_uuid' => ['required', 'uuid'],
        ];
    }
}
