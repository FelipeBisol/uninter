<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardMovement extends Model
{
    protected $table = 'card_movimentacao';

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'id_status');
    }
}
