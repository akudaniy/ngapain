<?php

namespace App\Filament\Resources\Objectives\Pages;

use App\Filament\Resources\Objectives\ObjectiveResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewObjective extends ViewRecord
{
    protected static string $resource = ObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
