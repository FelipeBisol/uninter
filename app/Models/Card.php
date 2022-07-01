<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'card';

    public function type()
    {
        return $this->belongsTo(Type::class, 'id_tipo', 'id_tipo');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'id_curso', 'id_curso');
    }

    public function card_teacher()
    {
        return $this->hasMany(CardTeacher::class, 'id_card','id_card');
    }

    public function card_material()
    {
        return $this->hasMany(CardMaterial::class, 'id_card', 'id_card');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'id_status', 'id_status');
    }
}
