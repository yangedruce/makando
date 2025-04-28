<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecordLog extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    */
    protected $table = 'record_logs';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'record_model_name',
        'record_id',
        'data'
    ];

    /**
     * Get user that belongs to the RecordLog.
     */
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id');
    }
}
