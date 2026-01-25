<?php

namespace App\Traits;

trait PersonaValidationMessages
{
    /**
     * Mensajes de validación comunes para Persona
     */
    protected static function personaMessages(): array
    {
        return [
            'primer_nombre.required' => 'El primer nombre es obligatorio.',
            'primer_nombre.string' => 'El primer nombre debe ser una cadena de texto.',
            'primer_nombre.max' => 'El primer nombre no puede exceder 255 caracteres.',
            'segundo_nombre.string' => 'El segundo nombre debe ser una cadena de texto.',
            'segundo_nombre.max' => 'El segundo nombre no puede exceder 255 caracteres.',
            'primer_apellido.required' => 'El primer apellido es obligatorio.',
            'primer_apellido.string' => 'El primer apellido debe ser una cadena de texto.',
            'primer_apellido.max' => 'El primer apellido no puede exceder 255 caracteres.',
            'segundo_apellido.string' => 'El segundo apellido debe ser una cadena de texto.',
            'segundo_apellido.max' => 'El segundo apellido no puede exceder 255 caracteres.',
            'tipo_documento_id.required' => 'El tipo de documento es obligatorio.',
            'tipo_documento_id.exists' => 'El tipo de documento seleccionado no es válido.',
            'numero_documento.required' => 'El número de documento es obligatorio.',
            'numero_documento.string' => 'El número de documento debe ser una cadena de texto.',
            'numero_documento.max' => 'El número de documento no puede exceder 255 caracteres.',
            'numero_documento.unique' => 'El número de documento ya está registrado.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.string' => 'El teléfono debe ser una cadena de texto.',
            'telefono.max' => 'El teléfono no puede exceder 255 caracteres.',
            'telefono.unique' => 'El teléfono ya está registrado.',
            'edad.required' => 'La edad es obligatoria.',
            'edad.integer' => 'La edad debe ser un número entero.',
            'edad.min' => 'La edad debe ser mayor o igual a 0.',
            'edad.max' => 'La edad debe ser menor o igual a 150.',
            'genero_id.required' => 'El género es obligatorio.',
            'genero_id.exists' => 'El género seleccionado no es válido.',
            'nivel_id.exists' => 'El nivel seleccionado no es válido.',
            'camisa.string' => 'La camisa debe ser una cadena de texto.',
            'camisa.max' => 'La camisa no puede exceder 255 caracteres.',
            'talla_id.exists' => 'La talla seleccionada no es válida.',
            'eps_id.exists' => 'La EPS seleccionada no es válida.',
            'pais_id.exists' => 'El país seleccionado no es válido.',
            'departamento_id.exists' => 'El departamento seleccionado no es válido.',
            'municipio_id.exists' => 'El municipio seleccionado no es válido.',
        ];
    }
}
