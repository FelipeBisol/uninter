<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    protected $table = 'material';

    public function card(): HasMany
    {
        return $this->hasMany(CardMaterial::class, 'id_material');
    }
}
