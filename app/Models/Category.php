<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'user_id',
    ];

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class,           
            'category_restaurant',
            'category_id',
            'restaurant_id'
        );
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
