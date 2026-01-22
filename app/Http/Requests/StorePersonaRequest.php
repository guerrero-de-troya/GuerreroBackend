<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonaRequest extends FormRequest
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
        return [
            'primer_nombre' => ['required', 'string', 'max:255'],
            'segundo_nombre' => ['nullable', 'string', 'max:255'],
            'primer_apellido' => ['required', 'string', 'max:255'],
            'segundo_apellido' => ['nullable', 'string', 'max:255'],
            'tipo_documento_id' => ['required', 'exists:parametros,id'],
            'numero_documento' => ['required', 'string', 'max:255', 'unique:personas,numero_documento'],
            'telefono' => ['required', 'string', 'max:255', 'unique:personas,telefono'],
            'edad' => ['required', 'integer', 'min:0', 'max:150'],
            'genero_id' => ['required', 'exists:parametros,id'],
            'nivel_id' => ['nullable', 'exists:parametros,id'],
            'camisa' => ['nullable', 'string', 'max:255'],
            'talla_id' => ['nullable', 'exists:parametros,id'],
            'eps_id' => ['nullable', 'exists:parametros,id'],
            'pais_id' => ['nullable', 'exists:paises,id'],
            'departamento_id' => ['nullable', 'exists:departamentos,id'],
            'municipio_id' => ['nullable', 'exists:municipios,id'],
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
            'primer_nombre.required' => 'El primer nombre es obligatorio.',
            'primer_nombre.string' => 'El primer nombre debe ser una cadena de texto.',
            'primer_nombre.max' => 'El primer nombre no puede exceder 255 caracteres.',
            'primer_apellido.required' => 'El primer apellido es obligatorio.',
            'primer_apellido.string' => 'El primer apellido debe ser una cadena de texto.',
            'primer_apellido.max' => 'El primer apellido no puede exceder 255 caracteres.',
            'tipo_documento_id.required' => 'El tipo de documento es obligatorio.',
            'tipo_documento_id.exists' => 'El tipo de documento seleccionado no es válido.',
            'numero_documento.required' => 'El número de documento es obligatorio.',
            'numero_documento.unique' => 'El número de documento ya está registrado.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.unique' => 'El teléfono ya está registrado.',
            'edad.required' => 'La edad es obligatoria.',
            'edad.integer' => 'La edad debe ser un número entero.',
            'edad.min' => 'La edad debe ser mayor o igual a 0.',
            'edad.max' => 'La edad debe ser menor o igual a 150.',
            'genero_id.required' => 'El género es obligatorio.',
            'genero_id.exists' => 'El género seleccionado no es válido.',
            'nivel_id.exists' => 'El nivel seleccionado no es válido.',
            'talla_id.exists' => 'La talla seleccionada no es válida.',
            'eps_id.exists' => 'La EPS seleccionada no es válida.',
            'pais_id.exists' => 'El país seleccionado no es válido.',
            'departamento_id.exists' => 'El departamento seleccionado no es válido.',
            'municipio_id.exists' => 'El municipio seleccionado no es válido.',
        ];
    }
}
