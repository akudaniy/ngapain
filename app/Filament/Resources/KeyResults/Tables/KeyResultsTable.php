<?php

namespace App\Filament\Resources\KeyResults\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KeyResultsTable
{
    public static function configure(Table $table, bool $showObjective = true): Table
    {
        $columns = [];

        if ($showObjective) {
            $columns[] = TextColumn::make('objective.name')
                ->label('Objective')
                ->searchable()
                ->sortable();
        }

        $columns = array_merge($columns, [
            TextColumn::make('name')
                ->searchable()
                ->sortable(),
            TextColumn::make('target_value')
                ->numeric()
                ->sortable(),
            TextColumn::make('current_value')
                ->numeric()
                ->sortable(),
            TextColumn::make('unit'),
        ]);

        return $table->columns($columns)
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
