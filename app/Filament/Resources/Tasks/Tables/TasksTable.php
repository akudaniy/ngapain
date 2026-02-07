<?php

namespace App\Filament\Resources\Tasks\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('project.name')
                    ->label('Project')
                    ->sortable(),
                TextColumn::make('assignedUser.name')
                    ->label('Assigned To')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'backlog' => 'gray',
                        'todo' => 'info',
                        'doing' => 'warning',
                        'in_review' => 'primary',
                        'done' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'low' => 'gray',
                        'medium' => 'info',
                        'high' => 'warning',
                        'urgent' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->sortable(),
                TextColumn::make('effort_score')
                    ->label('Effort')
                    ->sortable(),
                TextColumn::make('due_at')
                    ->label('Due Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
                TextColumn::make('started_at')
                    ->label('Started Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
                TextColumn::make('keyResult.name')
                    ->label('Key Result')
                    ->limit(20),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
