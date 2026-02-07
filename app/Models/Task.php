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

    public const STATUS_BACKLOG = 'backlog';
    public const STATUS_TODO = 'todo';
    public const STATUS_DOING = 'doing';
    public const STATUS_IN_REVIEW = 'in_review';
    public const STATUS_DONE = 'done';

    public const PRIORITY_LOW = 'low';
    public const PRIORITY_MEDIUM = 'medium';
    public const PRIORITY_HIGH = 'high';
    public const PRIORITY_URGENT = 'urgent';

    public const TYPE_TASK = 'task';
    public const TYPE_BUG = 'bug';
    public const TYPE_IMPROVEMENT = 'improvement';
    public const TYPE_REFACTOR = 'refactor';

    protected $fillable = [
        'project_id',
        'company_id',
        'parent_id',
        'key_result_id',
        'assigned_user_id',
        'name',
        'description',
        'is_self_initiated',
        'status',
        'priority',
        'type',
        'effort_score',
        'completed_at',
        'due_at',
        'started_at',
    ];

    protected $casts = [
        'is_self_initiated' => 'boolean',
        'completed_at' => 'datetime',
        'due_at' => 'datetime',
        'started_at' => 'datetime',
        'effort_score' => 'integer',
        'status' => 'string',
        'priority' => 'string',
        'type' => 'string',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function subtasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function keyResult(): BelongsTo
    {
        return $this->belongsTo(KeyResult::class);
    }
}
