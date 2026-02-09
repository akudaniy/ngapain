<?php

namespace App\Filament\Resources\Projects\Widgets;

use App\Models\Project;
use App\Models\Task;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ProjectStatusChart extends ChartWidget
{
    protected ?string $heading = 'Task Status Breakdown';

    public ?Project $record = null;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        if (!$this->record) {
            return [];
        }

        $data = Task::query()
            ->where('project_id', $this->record->id)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statuses = [
            Task::STATUS_DONE => 'Done',
            Task::STATUS_DOING => 'Doing',
            Task::STATUS_TODO => 'To Do',
            Task::STATUS_BACKLOG => 'Backlog',
            Task::STATUS_IN_REVIEW => 'In Review',
        ];

        $labels = [];
        $values = [];
        $colors = [
            Task::STATUS_DONE => '#10b981', // Green
            Task::STATUS_DOING => '#f59e0b', // Amber
            Task::STATUS_TODO => '#3b82f6', // Blue
            Task::STATUS_BACKLOG => '#9ca3af', // Gray
            Task::STATUS_IN_REVIEW => '#8b5cf6', // Violet
        ];
        $datasetColors = [];

        foreach ($statuses as $status => $label) {
            if (isset($data[$status])) {
                $labels[] = $label;
                $values[] = $data[$status];
                $datasetColors[] = $colors[$status] ?? '#cbd5e1';
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Tasks',
                    'data' => $values,
                    'backgroundColor' => $datasetColors,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
