<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckOverdueTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-overdue-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for overdue tasks and notify assignees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueTasks = \App\Models\Task::where('status', '!=', 'done')
            ->whereNotNull('due_at')
            ->where('due_at', '<', now())
            ->whereNotNull('assigned_user_id')
            ->get();

        foreach ($overdueTasks as $task) {
            $task->assignedUser->notify(new \App\Notifications\OverdueTask($task));
        }

        $this->info('Checked ' . $overdueTasks->count() . ' overdue tasks.');
    }
}
