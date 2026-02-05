<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JugadoraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'posicio' => $this->posicio,
            'dorsal' => $this->dorsal,
            'data_naixement' => $this->data_naixement, 
            'equip' => $this->whenLoaded('equip', fn() => [
                'id' => $this->equip->id,
                'nom' => $this->equip->nom,
            ]),
        ];
    }
}
