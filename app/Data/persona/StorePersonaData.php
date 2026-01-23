<?php

namespace App\Data\Persona;

class StorePersonaData extends PersonaBaseData
{
    public static function rules(): array
    {
        return array_merge(
            self::baseRules(),
            [
                'numero_documento' => ['required', 'string', 'max:255', 'unique:personas,numero_documento'],
                'telefono' => ['required', 'string', 'max:255', 'unique:personas,telefono'],
            ]
        );
    }
}

