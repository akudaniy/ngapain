<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class StaffToDoWidget extends TableWidget
{
    protected static ?string $heading = 'My To-Do Tasks';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Task::query()
                    ->where('assigned_user_id', auth()->id())
                    ->where('status', '!=', 'done')
                    ->latest()
            )
            ->columns([
                TextColumn::make('project.name')
                    ->label('Project')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Task')
                    ->description(fn (Task $record): string => $record->description ?? ''),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'todo' => 'gray',
                        'doing' => 'warning',
                        'done' => 'success',
                    }),
                TextColumn::make('effort_score')
                    ->numeric()
                    ->sortable(),
            ]);
    }
}
