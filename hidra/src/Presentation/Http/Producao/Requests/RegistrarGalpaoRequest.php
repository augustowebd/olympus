<?php

declare(strict_types=1);

namespace App\Presentation\Http\Producao\Requests;

use App\Domain\Producao\ValueObjects\Capacidade;
use App\Presentation\Http\Producao\Contracts\GalpaoPayload;
use Illuminate\Foundation\Http\FormRequest;

final class RegistrarGalpaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            GalpaoPayload::NOME => ['required', 'string', 'max:255'],
            GalpaoPayload::CAPACIDADE => ['required', 'integer', 'min:' . Capacidade::MINIMA],
            GalpaoPayload::NCL_UUID => ['required', 'uuid'],
        ];
    }
}
