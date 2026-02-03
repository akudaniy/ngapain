<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Filament\Resources\Tasks\TaskResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTask extends ViewRecord
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        $resource = static::getResource();
        $project = $this->getRecord()->project;

        return [
            \App\Filament\Resources\Projects\ProjectResource::getUrl('view', ['record' => $project]) => $project->name,
            static::getResource()::getUrl('view', ['record' => $this->getRecord()]) => __('filament-panels::resources/pages/view-record.breadcrumb'),
        ];
    }
}
