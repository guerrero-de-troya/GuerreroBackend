<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartamentoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'departamento' => $this->departamento,
            'pais_id' => $this->pais_id,
            'pais' => PaisResource::make($this->whenLoaded('pais')),
        ];
    }
}
