<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    */
    protected $table = 'activity_logs';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'activity',
        'record_route'
    ];

    /**
     * Get role that belongs to the User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
