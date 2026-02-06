<?php

namespace App\Filament\Resources\Tasks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema, bool $showProject = true): Schema
    {
        $components = [];

        if ($showProject) {
            $components[] = Select::make('project_id')
                ->relationship('project', 'name')
                ->required()
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(function (Get $get, callable $set, $livewire) {
                    $isManager = static::isProjectManager($get, $livewire);
                    $set('is_self_initiated', !$isManager);
                    if (!$isManager) {
                        $set('assigned_user_id', auth()->id());
                    }
                });
        }

        $components = array_merge($components, [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            Textarea::make('description')
                ->maxLength(65535)
                ->columnSpanFull(),
            Toggle::make('is_self_initiated')
                ->label('Is Self Initiated')
                ->default(fn (Get $get, $livewire) => !static::isProjectManager($get, $livewire))
                ->disabled(fn (Get $get, $livewire) => !static::isProjectManager($get, $livewire))
                ->dehydrated()
                ->live()
                ->afterStateUpdated(function ($state, callable $set) {
                    if ($state) {
                        $set('assigned_user_id', auth()->id());
                    }
                }),
            Select::make('assigned_user_id')
                ->relationship('assignedUser', 'name', modifyQueryUsing: function ($query, Get $get, $livewire) {
                    $query->whereDoesntHave('roles', fn ($q) => $q->where('name', 'super_admin'));

                    $projectId = $get('project_id') ?? $livewire->ownerRecord?->id;
                    if ($projectId) {
                        return $query->whereHas('projects', fn ($q) => $q->where('projects.id', $projectId));
                    }
                })
                ->label('Assigned To')
                ->searchable()
                ->preload()
                ->default(fn () => auth()->id())
                ->disabled(fn (Get $get, $livewire) => $get('is_self_initiated') || !static::isProjectManager($get, $livewire))
                ->dehydrated(),
            Select::make('status')
                ->options([
                    'todo' => 'To Do',
                    'doing' => 'Doing',
                    'done' => 'Done',
                ])
                ->required()
                ->default('todo')
                ->disableOptionWhen(function ($value, $record) {
                    if (! $record) {
                        return false;
                    }

                    $statusOrder = [
                        'todo' => 1,
                        'doing' => 2,
                        'done' => 3,
                    ];

                    return $statusOrder[$value] < $statusOrder[$record->status];
                })
                ->rules([
                    function ($get, $record) {
                        return function (string $attribute, $value, $fail) use ($record) {
                            if (! $record) {
                                return;
                            }

                            $statusOrder = [
                                'todo' => 1,
                                'doing' => 2,
                                'done' => 3,
                            ];

                            if ($statusOrder[$value] < $statusOrder[$record->status]) {
                                $fail("The status cannot be changed backward from {$record->status} to {$value}.");
                            }
                        };
                    },
                ]),
            DateTimePicker::make('due_at')
                ->label('Due Date')
                ->native(false),
            TextInput::make('effort_score')
                ->numeric()
                ->minValue(1)
                ->maxValue(10)
                ->default(0)
                ->hidden(fn (Get $get, $livewire) => !static::isProjectManager($get, $livewire))
                ->disabled(fn (Get $get, $livewire) => !static::isProjectManager($get, $livewire)),
        ]);

        return $schema->components($components);
    }

    protected static function isProjectManager(Get $get, $livewire): bool
    {
        $projectId = $get('project_id') ?? $livewire->ownerRecord?->id;

        if (! $projectId) {
            return false;
        }

        return auth()->user()->projects()
            ->where('projects.id', $projectId)
            ->wherePivot('role', 'manager')
            ->exists();
    }
}
