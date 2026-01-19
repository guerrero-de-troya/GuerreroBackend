<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Persona Resource
 *
 * Transforma el modelo Persona en una respuesta JSON estructurada.
 */
class PersonaResource extends JsonResource
{
    /**
     * Transformar el recurso en un array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'primer_nombre' => $this->primer_nombre,
            'segundo_nombre' => $this->segundo_nombre,
            'primer_apellido' => $this->primer_apellido,
            'segundo_apellido' => $this->segundo_apellido,
            'id_tipo_documento' => $this->id_tipo_documento,
            'numero_documento' => $this->numero_documento,
            'telefono' => $this->telefono,
            'edad' => $this->edad,
            'id_genero' => $this->id_genero,
            'id_categoria' => $this->id_categoria,
            'camisa' => $this->camisa,
            'id_talla' => $this->id_talla,
            'id_ciudad_origen' => $this->id_ciudad_origen,
            'eps' => $this->eps,
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
            'tipo_documento' => $this->whenLoaded('tipoDocumento'),
            'genero' => $this->whenLoaded('genero'),
            'categoria' => $this->whenLoaded('categoria'),
            'talla' => $this->whenLoaded('talla'),
            'ciudad_origen' => $this->whenLoaded('ciudadOrigen'),
            'user' => $this->whenLoaded('user'),
        ];
    }
}
