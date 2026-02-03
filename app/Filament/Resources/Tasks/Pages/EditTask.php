<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Filament\Resources\Tasks\TaskResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        $resource = static::getResource();
        $project = $this->getRecord()->project;

        return [
            \App\Filament\Resources\Projects\ProjectResource::getUrl('view', ['record' => $project]) => $project->name,
            static::getResource()::getUrl('edit', ['record' => $this->getRecord()]) => __('filament-panels::resources/pages/edit-record.breadcrumb'),
        ];
    }
}
