<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MunicipioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'municipio' => $this->municipio,
            'departamento_id' => $this->departamento_id,
            'departamento' => DepartamentoResource::make($this->whenLoaded('departamento')),
        ];
    }
}
