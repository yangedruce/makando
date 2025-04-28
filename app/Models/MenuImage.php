<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuImage extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'menu_id',
        'path',
        'name',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
