<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardTeacher extends Model
{
    protected $table = 'card_professor';

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'id_professor', 'id_professor');
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'id_card');
    }
}
