<?php

namespace App\Filament\Resources\KeyResults\Pages;

use App\Filament\Resources\KeyResults\KeyResultResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKeyResults extends ListRecords
{
    protected static string $resource = KeyResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
