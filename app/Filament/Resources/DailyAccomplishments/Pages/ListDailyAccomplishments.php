<?php

namespace App\Filament\Resources\DailyAccomplishments\Pages;

use App\Filament\Resources\DailyAccomplishments\DailyAccomplishmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDailyAccomplishments extends ListRecords
{
    protected static string $resource = DailyAccomplishmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
