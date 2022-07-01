<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $string = explode(" ", $this->teacher->nome );
        $first = $string[0];
        $end = end($string);
        return [
            'nome' => "$first $end"
        ];
    }
}
