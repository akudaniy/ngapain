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

    protected static ?int $sort = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Task::query()
                    ->with(['project', 'parent'])
                    ->where('assigned_user_id', auth()->id())
                    ->where('status', '!=', 'done')
                    ->latest()
            )
            ->columns([
                TextColumn::make('project.name')
                    ->label('Project')
                    ->url(fn (Task $record): string => route('filament.admin.resources.projects.view', $record->project))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Task')
                    ->url(fn (Task $record): string => route('filament.admin.resources.tasks.view', $record))
                    ->description(function (Task $record) {
                        $descriptions = [];
                        if ($record->parent) {
                            $descriptions[] = "Part of: {$record->parent->name}";
                        }
                        if ($record->description) {
                            $descriptions[] = $record->description;
                        }
                        return implode(' | ', $descriptions);
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'todo' => 'gray',
                        'doing' => 'warning',
                        'done' => 'success',
                    }),
            ]);
    }
}
