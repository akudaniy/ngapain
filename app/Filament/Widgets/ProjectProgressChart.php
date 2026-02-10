<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Models\Task;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ProjectProgressChart extends ChartWidget
{
    protected ?string $heading = 'Project Completion Progress (%)';
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $projects = Project::withCount(['tasks', 'tasks as completed_tasks_count' => function ($query) {
            $query->where('status', Task::STATUS_DONE);
        }])->get();

        $labels = [];
        $values = [];

        foreach ($projects as $project) {
            $labels[] = $project->name;
            $total = $project->tasks_count;
            $completed = $project->completed_tasks_count;

            $progress = $total > 0 ? round(($completed / $total) * 100, 2) : 0;
            $values[] = $progress;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Completion Percentage',
                    'data' => $values,
                    'backgroundColor' => '#f43f5e',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
