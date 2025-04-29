<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'address',
        'status',
        'user_id',
        'is_opened',
        'inactive_at',
    ];

    protected $attributes = [
        'status' => 'Inactive',
        'is_opened' => false,
    ];

    protected $casts = [
        'inactive_at' => 'datetime',
    ];    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,
            'category_restaurant',
            'restaurant_id',
            'category_id'
        );
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function types()
    {
        return $this->hasMany(Type::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getIsInactiveAttribute()
    {
        if ($this->status === 'Inactive' && $this->inactive_at) {
            return $this->inactive_at->diffInDays(now()) >= 7;
        }
        return false;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }
}
