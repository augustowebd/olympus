<?php

declare(strict_types=1);

namespace App\Presentation\Http\Producao\Requests;

use App\Presentation\Http\Producao\Contracts\NucleoPayload;
use Illuminate\Foundation\Http\FormRequest;

final class AlterarNucleoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            NucleoPayload::NOME => ['required', 'string', 'max:255'],
        ];
    }
}
