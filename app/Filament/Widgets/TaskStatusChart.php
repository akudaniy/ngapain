<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TaskStatusChart extends ChartWidget
{
    protected ?string $heading = 'Task Status Distribution';
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = Task::query()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statuses = [
            Task::STATUS_BACKLOG => 'Backlog',
            Task::STATUS_TODO => 'To Do',
            Task::STATUS_DOING => 'Doing',
            Task::STATUS_IN_REVIEW => 'In Review',
            Task::STATUS_DONE => 'Done',
        ];

        $labels = [];
        $values = [];
        $colors = [
            Task::STATUS_BACKLOG => '#94a3b8',
            Task::STATUS_TODO => '#64748b',
            Task::STATUS_DOING => '#3b82f6',
            Task::STATUS_IN_REVIEW => '#f59e0b',
            Task::STATUS_DONE => '#10b981',
        ];

        $backgroundColors = [];

        foreach ($statuses as $key => $label) {
            $labels[] = $label;
            $values[] = $data[$key] ?? 0;
            $backgroundColors[] = $colors[$key];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Tasks',
                    'data' => $values,
                    'backgroundColor' => $backgroundColors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
