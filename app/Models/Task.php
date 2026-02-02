<?php

namespace App\Models;

use App\Observers\TaskObserver;
use App\Traits\HasCompany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(TaskObserver::class)]
class Task extends Model
{
    use HasUuids, HasCompany;

    protected $fillable = [
        'project_id',
        'company_id',
        'assigned_user_id',
        'name',
        'description',
        'is_self_initiated',
        'status',
        'effort_score',
        'completed_at',
    ];

    protected $casts = [
        'is_self_initiated' => 'boolean',
        'completed_at' => 'datetime',
        'effort_score' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
}
