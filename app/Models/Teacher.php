<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $table = 'professor';

    public function card(): HasMany
    {
        return $this->hasMany(CardTeacher::class, 'id_professor', 'id_professor');
    }
}
