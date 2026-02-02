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
                ->preload();
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
                ->default(fn () => !auth()->user()->can('Assign:Task'))
                ->disabled(fn () => !auth()->user()->can('Assign:Task'))
                ->dehydrated()
                ->live()
                ->afterStateUpdated(function ($state, callable $set) {
                    if ($state) {
                        $set('assigned_user_id', auth()->id());
                    }
                }),
            Select::make('assigned_user_id')
                ->relationship('assignedUser', 'name')
                ->label('Assigned To')
                ->searchable()
                ->preload()
                ->default(fn () => auth()->id())
                ->disabled(fn (Get $get) => $get('is_self_initiated') || !auth()->user()->can('Assign:Task'))
                ->dehydrated(),
            Select::make('status')
                ->options([
                    'todo' => 'To Do',
                    'doing' => 'Doing',
                    'done' => 'Done',
                ])
                ->required()
                ->default('todo'),
            DateTimePicker::make('due_at')
                ->label('Due Date')
                ->native(false),
            TextInput::make('effort_score')
                ->numeric()
                ->minValue(1)
                ->maxValue(10)
                ->default(0)
                ->hidden(fn () => !auth()->user()->can('Assign:Task')) // Hidden for creators who aren't managers
                ->disabled(fn () => !auth()->user()->can('Assign:Task')),
        ]);

        return $schema->components($components);
    }
}
