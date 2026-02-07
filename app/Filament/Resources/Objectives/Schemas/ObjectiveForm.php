<?php

namespace App\Filament\Resources\Objectives\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ObjectiveForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                MarkdownEditor::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                DatePicker::make('start_date')
                    ->required()
                    ->firstDayOfWeek(0)
                    ->native(false),
                DatePicker::make('end_date')
                    ->required()
                    ->firstDayOfWeek(0)
                    ->native(false),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'achieved' => 'Achieved',
                        'abandoned' => 'Abandoned',
                    ])
                    ->required()
                    ->default('active'),
            ]);
    }
}
