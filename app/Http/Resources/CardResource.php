<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id_card' => $this->id_card,
            'tipo' => $this->type->tipo,
            'curso' => $this->when($this->course !== null, $this->course),
            'status' => [
                'status' => $this->status->status,
                'cor' => $this->status->cor,
                'id_status' => $this->status->id_status
            ],
            'dt_registro' => $this->dt_registro,
            'ano' => $this->ano,
            'aula' => $this->num_aula,
            'professores' => TeacherResource::collection($this->card_teacher),
            'materiais' => MaterialResource::collection($this->card_material)
        ];
    }
}
