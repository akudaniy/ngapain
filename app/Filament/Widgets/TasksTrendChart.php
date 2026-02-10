<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TasksTrendChart extends ChartWidget
{
    protected ?string $heading = 'Completed Tasks (Last 30 Days)';
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = Task::query()
            ->where('status', Task::STATUS_DONE)
            ->where('completed_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(completed_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $labels = [];
        $values = [];

        for ($i = 30; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('M d');
            $values[] = $data[$date] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Tasks Completed',
                    'data' => $values,
                    'borderColor' => '#10b981',
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
