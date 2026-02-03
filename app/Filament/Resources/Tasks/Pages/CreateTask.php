<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Filament\Resources\Tasks\TaskResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;

    public function getBreadcrumbs(): array
    {
        $projectId = request()->query('project_id');
        if ($projectId) {
            $project = \App\Models\Project::find($projectId);
            if ($project) {
                return [
                    \App\Filament\Resources\Projects\ProjectResource::getUrl('view', ['record' => $project]) => $project->name,
                    static::getUrl() => __('filament-panels::resources/pages/create-record.breadcrumb'),
                ];
            }
        }

        return parent::getBreadcrumbs();
    }
}
