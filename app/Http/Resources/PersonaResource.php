<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'primer_nombre' => $this->primer_nombre,
            'segundo_nombre' => $this->segundo_nombre,
            'primer_apellido' => $this->primer_apellido,
            'segundo_apellido' => $this->segundo_apellido,
            'tipo_documento_id' => $this->tipo_documento_id,
            'numero_documento' => $this->numero_documento,
            'telefono' => $this->telefono,
            'edad' => $this->edad,
            'genero_id' => $this->genero_id,
            'nivel_id' => $this->nivel_id,
            'camisa' => $this->camisa,
            'talla_id' => $this->talla_id,
            'eps_id' => $this->eps_id,
            'pais_id' => $this->pais_id,
            'departamento_id' => $this->departamento_id,
            'municipio_id' => $this->municipio_id,
            'tipo_documento' => $this->whenLoaded('tipoDocumento'),
            'genero' => $this->whenLoaded('genero'),
            'nivel' => $this->whenLoaded('nivel'),
            'talla' => $this->whenLoaded('talla'),
            'eps' => $this->whenLoaded('eps'),
            'pais' => $this->whenLoaded('pais'),
            'departamento' => $this->whenLoaded('departamento'),
            'municipio' => $this->whenLoaded('municipio'),
            'user' => $this->whenLoaded('user'),
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}
