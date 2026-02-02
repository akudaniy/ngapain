<?php

namespace App\Models;

use App\Traits\HasCompany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyAccomplishment extends Model
{
    use HasUuids, HasCompany;

    protected $fillable = [
        'user_id',
        'company_id',
        'date',
        'content',
        'tasks_completed_snapshot',
    ];

    protected $casts = [
        'date' => 'date',
        'tasks_completed_snapshot' => 'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
