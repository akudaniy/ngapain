<?php

namespace App\Filament\Resources\KeyResults\Pages;

use App\Filament\Resources\KeyResults\KeyResultResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKeyResult extends EditRecord
{
    protected static string $resource = KeyResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
