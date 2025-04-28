<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

use App\Observers\PermissionRoleObserver;

#[ObservedBy([PermissionRoleObserver::class])]
class PermissionRole extends Pivot
{
    use HasFactory;

    /**
    * The table associated with the model.
    */
    protected $table = 'permission_role';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'permission_id',
        'role_id'
    ];

    /**
     * Get permission that belong to the PermissionRole.
     */
    public function permission()
    {
        return $this->BelongsTo(Permission::class);
    }

    /**
     * Get role that belong to the PermissionRole.
     */
    public function role()
    {
        return $this->BelongsTo(Role::class);
    }
}
