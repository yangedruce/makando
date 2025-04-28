<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Permission extends Model
{
    use HasUuids, HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    /**
    * The table associated with the model.
    */
    protected $table = 'permissions';
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'is_deletable'
    ];
    
    /**
     * Perform actions when model is loaded into memory.
     */
    public static function boot()
    {
        parent::boot();

         /**
         * Get submodules name from a collection of permissions.
         * 
         * Usage example:
         * Permission::all()->submodules();
         */
        Collection::macro('submodules', function () {
            return $this->groupBy(function ($permission) {
                return explode(':', $permission->name)[0];
            });
        });
    }

    /**
     * Get role that belong to the Permission.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->using(PermissionRole::class);
    }
}
