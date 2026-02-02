<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Filament\Resources\Tasks\Schemas\TaskForm;
use App\Models\User;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    public function form(Schema $schema): Schema
    {
        return TaskForm::configure($schema, showProject: false);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('assignedUser.name')
                    ->label('Assigned To')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('due_at')
                    ->label('Due Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
                TextColumn::make('effort_score')
                    ->label('Effort')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('assigned_user_id')
                    ->label('Assigned To')
                    ->options(fn () => User::pluck('name', 'id')->toArray())
                    ->searchable(),
                SelectFilter::make('status')
                    ->options([
                        'todo' => 'To Do',
                        'doing' => 'Doing',
                        'done' => 'Done',
                    ]),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Task')
                    ->authorize(fn () => auth()->user()->can('Create:Task')),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->url(fn ($record) => route('filament.admin.resources.tasks.view', $record)),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
