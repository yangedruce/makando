<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Observers\RoleObserver;

#[ObservedBy([RoleObserver::class])]
class Role extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    /**
    * The table associated with the model.
    */
    protected $table = 'roles';
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description'
    ];
    
    /**
     * Get user that belong to the Role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(RoleUser::class);
    }

    /**
     * Get permission that belong to the Role.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->using(PermissionRole::class);
    }
}
