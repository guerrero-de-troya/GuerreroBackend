<?php

namespace App\Data\Persona;

class UpdatePersonaData extends PersonaBaseData
{
    public static function rules(int $personaId): array
    {
        $rules = collect(self::baseRules())
            ->map(fn ($rule) =>
                array_map(
                    fn ($r) => $r === 'required' ? 'sometimes' : $r,
                    $rule
                )
            )
            ->toArray();

        $rules['numero_documento'][] = "unique:personas,numero_documento,{$personaId}";
        $rules['telefono'][] = "unique:personas,telefono,{$personaId}";

        return $rules;
    }
}

