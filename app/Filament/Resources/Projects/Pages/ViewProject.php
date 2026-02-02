<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\RelationManagers\TasksRelationManager;
use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Tasks\Schemas\TaskForm;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make('addTask')
                ->label('Add Task')
                ->model(\App\Models\Task::class)
                ->authorize(fn () => auth()->user()->can('Create:Task'))
                ->form(fn (Schema $schema) => TaskForm::configure($schema, showProject: false))
                ->mutateFormDataUsing(function (array $data): array {
                    $data['project_id'] = $this->record->id;

                    return $data;
                }),
            EditAction::make(),
        ];
    }

    public function getRelationManagers(): array
    {
        return [
            TasksRelationManager::class,
        ];
    }
}
