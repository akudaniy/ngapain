<?php

namespace App\Filament\Resources\Objectives\RelationManagers;

use App\Filament\Resources\KeyResults\Schemas\KeyResultForm;
use App\Filament\Resources\KeyResults\Tables\KeyResultsTable;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KeyResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'keyResults';


    public function form(Schema $schema): Schema
    {
        return KeyResultForm::configure($schema, showObjective: false);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('target_value')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('current_value')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('unit')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('New Key Result'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
