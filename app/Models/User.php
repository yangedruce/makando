<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

use App\Observers\UserObserver;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements MustVerifyEmail
{
    use HasUuids, HasFactory, Notifiable, SoftDeletes, Billable;

    protected $keyType = 'string';
    public $incrementing = false;

    /**
    * The table associated with the model.
    */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_force_password_change',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get role that belongs to the User.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->using(RoleUser::class)->withTrashed();
    }

    /**
     * Check if user has role defined in `$role`.
     */
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * Check if user is user is last super admin.
     */
    public function isLastSuperAdmin(): bool
    {
        if ($this->hasRole('super admin')) {
            $superAdminCount = $this->whereHas('roles', function($query) {
                $query->where('name', 'super admin');
            })->count();

            if ($superAdminCount <= 1) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user is a customer.
     */
    public function isCustomer(): bool
    {
        return $this->hasRole('Customer');
    }

    /**
     * Check if user has permission defined in `$permission`.
     */
    public function hasPermissions($permission)
    {
        return $this->roles()->whereHas('permissions', function($query) use ($permission) {
            $query->where('name', $permission);
        })->exists();
    }

    /**
     * Get the customer that belongs to the user.
     */
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    /**
     * Get the orders that belong to the user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the restaurants that belong to the user.
     */
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    /**
     * Get the carts that belong to the user.
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the latest cart that belongs to the user.
     */
    public function cart()
    {
        return $this->hasOne(Cart::class)->latest();
    }
}
