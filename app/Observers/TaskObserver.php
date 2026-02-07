<?php

namespace App\Observers;

use App\Models\Task;
use App\Notifications\TaskAssigned;
use App\Notifications\TaskCompleted;
use Illuminate\Support\Facades\Notification;

class TaskObserver
{
    /**
     * Handle the Task "saving" event.
     */
    public function saving(Task $task): void
    {
        if ($task->isDirty('status') && $task->status === 'done') {
            $task->completed_at = now();
        }

        // Automate company_id from project if not set
        if (!$task->company_id && $task->project_id) {
            $task->company_id = $task->project->company_id;
        }

        // Data Integrity: A TaskObserver ensures that when a status hits 'done', the completed_at timestamp is locked.
        if ($task->getOriginal('status') === 'done' && $task->isDirty('completed_at')) {
            $task->completed_at = $task->getOriginal('completed_at');
        }
    }

    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        // Notify assignee
        if ($task->assigned_user_id && $task->assigned_user_id !== auth()->id()) {
            $task->assignedUser->notify(new TaskAssigned($task));
        }
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        // Notify new assignee if changed
        if ($task->isDirty('assigned_user_id') && $task->assigned_user_id && $task->assigned_user_id !== auth()->id()) {
            $task->assignedUser->notify(new TaskAssigned($task));
        }

        // Notify project managers when task is done
        if ($task->isDirty('status') && $task->status === 'done') {
            $projectManagers = $task->project->users()
                ->wherePivot('role', 'manager')
                ->where('users.id', '!=', auth()->id())
                ->get();

            if ($projectManagers->isNotEmpty()) {
                Notification::send($projectManagers, new TaskCompleted($task));
            }
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
