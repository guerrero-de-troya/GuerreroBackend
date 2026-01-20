<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Update Persona Request
 *
 * Valida los datos para actualizar una persona existente.
 */
class UpdatePersonaRequest extends FormRequest
{
    /**
     * Determinar si el usuario está autorizado para hacer esta petición
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtener las reglas de validación que se aplican a la petición
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $personaId = $this->route('persona');

        return [
            'primer_nombre' => ['sometimes', 'string', 'max:255'],
            'segundo_nombre' => ['nullable', 'string', 'max:255'],
            'primer_apellido' => ['sometimes', 'string', 'max:255'],
            'segundo_apellido' => ['nullable', 'string', 'max:255'],
            'tipo_documento_id' => ['sometimes', 'exists:parametros_temas,id'],
            'numero_documento' => ['sometimes', 'string', 'max:255', "unique:personas,numero_documento,{$personaId}"],
            'telefono' => ['sometimes', 'string', 'max:255', "unique:personas,telefono,{$personaId}"],
            'edad' => ['sometimes', 'integer', 'min:0', 'max:150'],
            'genero_id' => ['sometimes', 'exists:parametros_temas,id'],
            'categoria_id' => ['sometimes', 'exists:parametros_temas,id'],
            'camisa' => ['nullable', 'string', 'max:255'],
            'talla_id' => ['nullable', 'exists:parametros_temas,id'],
            'ciudad_origen_id' => ['sometimes', 'exists:parametros_temas,id'],
            'eps_id' => ['sometimes', 'nullable', 'exists:parametros_temas,id'],
            'pais_id' => ['sometimes', 'nullable', 'exists:paises,id'],
            'departamento_id' => ['sometimes', 'nullable', 'exists:departamentos,id'],
            'municipio_id' => ['sometimes', 'nullable', 'exists:municipios,id'],
        ];
    }

    /**
     * Obtener mensajes de error personalizados para las reglas de validación
     *
     * @return array<string, string>
     */
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
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'talla_id.exists' => 'La talla seleccionada no es válida.',
            'ciudad_origen_id.exists' => 'La ciudad de origen seleccionada no es válida.',
            'eps_id.exists' => 'La EPS seleccionada no es válida.',
            'pais_id.exists' => 'El país seleccionado no es válido.',
            'departamento_id.exists' => 'El departamento seleccionado no es válido.',
            'municipio_id.exists' => 'El municipio seleccionado no es válido.',
        ];
    }
}
