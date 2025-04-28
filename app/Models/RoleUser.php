<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

use App\Observers\RoleUserObserver;

#[ObservedBy([RoleUserObserver::class])]
class RoleUser extends Pivot
{
    use HasFactory;
    
    /**
    * The table associated with the model.
    */
    protected $table = 'role_user';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'role_id',
        'user_id',
    ];

    /**
     * Get role that belong to the RoleUser.
     */
    public function role()
    {
        return $this->BelongsTo(Role::class);
    }

    /**
     * Get user that belong to the RoleUser.
     */
    public function user()
    {
        return $this->BelongsTo(User::class);
    }
}
