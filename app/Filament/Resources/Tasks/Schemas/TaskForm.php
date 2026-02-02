<?php

namespace App\Filament\Resources\Tasks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('company_id')
                    ->relationship('company', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Select::make('assigned_user_id')
                    ->relationship('assignedUser', 'name')
                    ->label('Assigned To')
                    ->searchable()
                    ->preload()
                    ->default(fn () => auth()->id())
                    ->disabled(fn () => !auth()->user()->can('assign_tasks')), // Assuming 'assign_tasks' permission for managers
                Toggle::make('is_self_initiated')
                    ->default(fn () => !auth()->user()->can('assign_tasks'))
                    ->disabled()
                    ->dehydrated(),
                Select::make('status')
                    ->options([
                        'todo' => 'To Do',
                        'doing' => 'Doing',
                        'done' => 'Done',
                    ])
                    ->required()
                    ->default('todo'),
                TextInput::make('effort_score')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(10)
                    ->default(0)
                    ->hidden(fn () => !auth()->user()->can('assign_tasks')) // Hidden for creators who aren't managers
                    ->disabled(fn () => !auth()->user()->can('assign_tasks')),
            ]);
    }
}
