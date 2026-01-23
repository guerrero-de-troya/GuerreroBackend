<?php

namespace App\Http\Requests\Traits;

trait NormalizesEmail
{
    protected function prepareForValidation(): void
    {
        if ($this->has('email')) {
            $this->merge([
                'email' => strtoupper($this->input('email')),
            ]);
        }
    }
}
