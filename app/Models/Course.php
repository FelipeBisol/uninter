<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'curso';

    public function cards()
    {
        return $this->hasMany(Card::class, 'id_curso');
    }
}
