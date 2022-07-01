<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'tipo';

    public function card()
    {
        return $this->hasMany(Card::class, 'id_tipo', 'id_tipo');
    }
}
