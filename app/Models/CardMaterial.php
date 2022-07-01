<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardMaterial extends Model
{
    protected $table = 'card_material';

    public function material()
    {
        return $this->belongsTo(Material::class, 'id_material', 'id_material');
    }
}
