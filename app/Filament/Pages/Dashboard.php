<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DailyAccomplishmentWidget;
use App\Filament\Widgets\StaffToDoWidget;
use App\Filament\Widgets\ActivityCalendarWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            StaffToDoWidget::class,
            DailyAccomplishmentWidget::class,
            ActivityCalendarWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 2;
    }
}
