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
            ->modifyQueryUsing(fn ($query) => $query->with(['parent', 'assignedUser']))
            ->columns([
                TextColumn::make('name')
                    ->formatStateUsing(function ($record, $state) {
                        $depth = $record->getDepth();
                        if ($depth === 0) {
                            return $state;
                        }

                        $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $depth);
                        return new \Illuminate\Support\HtmlString("{$indent} ↳ {$state}");
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('assignedUser.name')
                    ->label('Assigned To')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('start_at')
                    ->label('Start Date')
                    ->dateTime('M d, Y')
                    ->sortable(),
                TextColumn::make('due_at')
                    ->label('Due Date')
                    ->dateTime('M d, Y')
                    ->sortable(),
                TextColumn::make('completed_at')
                    ->label('Completed Date')
                    ->dateTime('M d, Y')
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
                    ->authorize(fn (RelationManager $livewire) =>
                        auth()->user()->hasRole('super_admin') ||
                        (auth()->user()->can('Create:Task') && $livewire->getOwnerRecord()->users()->where('users.id', auth()->id())->exists())
                    ),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->url(fn ($record) => route('filament.admin.resources.tasks.view', $record)),
                    EditAction::make()
                        ->url(fn ($record) => route('filament.admin.resources.tasks.edit', $record))
                        ->authorize(fn ($record) =>
                            auth()->user()->hasRole('super_admin') ||
                            (auth()->user()->can('Update:Task') && $record->project->users()->where('users.id', auth()->id())->exists())
                        ),
                    DeleteAction::make()
                        ->authorize(fn ($record) =>
                            auth()->user()->hasRole('super_admin') ||
                            (auth()->user()->can('Delete:Task') && $record->project->users()->where('users.id', auth()->id())->exists())
                        ),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
