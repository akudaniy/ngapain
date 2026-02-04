<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DailyAccomplishmentWidget;
use App\Filament\Widgets\StaffToDoWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            StaffToDoWidget::class,
            DailyAccomplishmentWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 2;
    }
}
