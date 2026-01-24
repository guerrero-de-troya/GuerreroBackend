<?php

namespace App\Http\Requests;

use App\Data\Auth\VerifyEmailData;
use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return VerifyEmailData::rules();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
            'hash' => $this->route('hash'),
        ]);
    }

    public function toDto(): VerifyEmailData
    {
        return new VerifyEmailData(
            id: (int) $this->validated('id'),
            hash: $this->validated('hash')
        );
    }
}
