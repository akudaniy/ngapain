<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class EffortByStaffChart extends ChartWidget
{
    protected ?string $heading = 'Total Effort score by Staff';
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = Task::query()
            ->whereNotNull('assigned_user_id')
            ->select('assigned_user_id', DB::raw('sum(effort_score) as total_effort'))
            ->groupBy('assigned_user_id')
            ->get();

        $userIds = $data->pluck('assigned_user_id')->toArray();
        $users = User::whereIn('id', $userIds)->pluck('name', 'id')->toArray();

        $labels = [];
        $values = [];

        foreach ($data as $item) {
            $labels[] = $users[$item->assigned_user_id] ?? 'Unknown';
            $values[] = $item->total_effort;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Effort Score',
                    'data' => $values,
                    'backgroundColor' => '#6366f1',
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
