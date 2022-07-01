<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    protected $table = 'status';

    public function movement(): HasMany
    {
        return $this->hasMany(CardMovement::class, 'id_status');
    }
}
