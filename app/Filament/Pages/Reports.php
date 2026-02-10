<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\EffortByStaffChart;
use App\Filament\Widgets\ProjectProgressChart;
use App\Filament\Widgets\TaskStatusChart;
use App\Filament\Widgets\TasksTrendChart;
use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Reports extends Page
{
    use HasPageShield;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-presentation-chart-bar';
    protected static string | \UnitEnum | null $navigationGroup = 'Dashboard';
    protected static ?string $navigationLabel = 'Reports';
    protected ?string $heading = 'Graphical Reports';

    protected string $view = 'filament.pages.reports';

    protected function getHeaderWidgets(): array
    {
        return [
            TaskStatusChart::class,
            ProjectProgressChart::class,
            EffortByStaffChart::class,
            TasksTrendChart::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 2;
    }
}
