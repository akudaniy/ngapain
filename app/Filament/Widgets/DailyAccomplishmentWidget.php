<?php

namespace App\Filament\Widgets;

use App\Models\DailyAccomplishment;
use Filament\Widgets\Widget;
use Illuminate\Support\Str;

class DailyAccomplishmentWidget extends Widget
{
    protected string $view = 'filament.widgets.daily-accomplishment-widget';

    protected static ?int $sort = 2;

    public ?DailyAccomplishment $accomplishment = null;

    protected int | string | array $columnSpan = 1;

    public function mount(): void
    {
        $this->accomplishment = DailyAccomplishment::query()
            ->where('user_id', auth()->id())
            ->whereDate('date', now())
            ->first();
    }

    public function getExcerptProperty(): string
    {
        if (! $this->accomplishment) {
            return '';
        }

        return Str::words($this->accomplishment->content, 20);
    }
}
