<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ActivityCalendarWidget extends Widget
{
    protected string $view = 'filament.widgets.activity-calendar-widget';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';
}
