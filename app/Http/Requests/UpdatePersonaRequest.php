<?php

namespace App\Http\Requests;

use App\Data\Persona\UpdatePersonaData;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $personaId = $this->route('persona');

        return UpdatePersonaData::rules($personaId);
    }

    public function messages(): array
    {
        return [
            'primer_nombre.string' => 'El primer nombre debe ser una cadena de texto.',
            'primer_nombre.max' => 'El primer nombre no puede exceder 255 caracteres.',
            'primer_apellido.string' => 'El primer apellido debe ser una cadena de texto.',
            'primer_apellido.max' => 'El primer apellido no puede exceder 255 caracteres.',
            'numero_documento.unique' => 'El número de documento ya está registrado.',
            'telefono.unique' => 'El teléfono ya está registrado.',
            'edad.integer' => 'La edad debe ser un número entero.',
            'edad.min' => 'La edad debe ser mayor o igual a 0.',
            'edad.max' => 'La edad debe ser menor o igual a 100.',
            'tipo_documento_id.exists' => 'El tipo de documento seleccionado no es válido.',
            'genero_id.exists' => 'El género seleccionado no es válido.',
            'nivel_id.exists' => 'El nivel seleccionado no es válido.',
            'talla_id.exists' => 'La talla seleccionada no es válida.',
            'eps_id.exists' => 'La EPS seleccionada no es válida.',
            'pais_id.exists' => 'El país seleccionado no es válido.',
            'departamento_id.exists' => 'El departamento seleccionado no es válido.',
            'municipio_id.exists' => 'El municipio seleccionado no es válido.',
        ];
    }

    public function toDto(): UpdatePersonaData
    {
        return UpdatePersonaData::from($this->validated());
    }
}
