<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected ?string $token = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'persona_id' => $this->persona_id,
            'persona' => $this->whenLoaded('persona'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        // Incluir token si está disponible
        if ($this->token !== null) {
            $data['token'] = $this->token;
        }

        return $data;
    }

    public function withToken(string $token): static
    {
        $this->token = $token;
        
        return $this;
    }
}
