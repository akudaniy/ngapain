<?php

namespace App\Filament\Resources\DailyAccomplishments\Pages;

use App\Filament\Resources\DailyAccomplishments\DailyAccomplishmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDailyAccomplishment extends EditRecord
{
    protected static string $resource = DailyAccomplishmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
