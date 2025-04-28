<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasUuids;

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
