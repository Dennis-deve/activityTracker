<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityUpdate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'daily_activity_log_id',
        'user_id',
        'status',
        'remark',
        'updated_at_time',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'updated_at_time' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the daily log this update belongs to.
     */
    public function dailyLog(): BelongsTo
    {
        return $this->belongsTo(DailyActivityLog::class, 'daily_activity_log_id');
    }

    /**
     * Get the user who made this update.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
