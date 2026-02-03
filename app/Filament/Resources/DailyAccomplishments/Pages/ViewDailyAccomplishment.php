<?php

namespace App\Filament\Resources\DailyAccomplishments\Pages;

use App\Filament\Resources\DailyAccomplishments\DailyAccomplishmentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDailyAccomplishment extends ViewRecord
{
    protected static string $resource = DailyAccomplishmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
