<?php

namespace App\Filament\Resources\KeyResults\Schemas;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KeyResultForm
{
    public static function configure(Schema $schema, bool $showObjective = true): Schema
    {
        $components = [];

        if ($showObjective) {
            $components[] = Select::make('objective_id')
                ->relationship('objective', 'name')
                ->required()
                ->searchable()
                ->preload();
        }

        $components = array_merge($components, [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            MarkdownEditor::make('description')
                ->maxLength(65535)
                ->columnSpanFull(),
            TextInput::make('target_value')
                ->numeric()
                ->required(),
            TextInput::make('current_value')
                ->numeric()
                ->default(0),
            TextInput::make('unit')
                ->default('%')
                ->required(),
        ]);

        return $schema->components($components);
    }
}
