<?php

namespace App\Filament\Resources\Objectives;

use App\Filament\Resources\Objectives\Pages\CreateObjective;
use App\Filament\Resources\Objectives\Pages\EditObjective;
use App\Filament\Resources\Objectives\Pages\ListObjectives;
use App\Filament\Resources\Objectives\Pages\ViewObjective;
use App\Filament\Resources\Objectives\Schemas\ObjectiveForm;
use App\Filament\Resources\Objectives\Tables\ObjectivesTable;
use App\Models\Objective;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ObjectiveResource extends Resource
{
    protected static ?string $model = Objective::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ObjectiveForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ObjectivesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\KeyResultsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListObjectives::route('/'),
            'create' => CreateObjective::route('/create'),
            'view' => ViewObjective::route('/{record}'),
            'edit' => EditObjective::route('/{record}/edit'),
        ];
    }

    public static function infolist(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Objective Details')
                    ->components([
                        \Filament\Infolists\Components\TextEntry::make('name')
                            ->size(\Filament\Support\Enums\TextSize::Large)
                            ->weight(\Filament\Support\Enums\FontWeight::Bold)
                            ->columnSpanFull(),

                        \Filament\Infolists\Components\TextEntry::make('description')
                            ->markdown()
                            ->columnSpanFull(),

                        \Filament\Schemas\Components\Grid::make(3)
                            ->components([
                                \Filament\Infolists\Components\TextEntry::make('company.name')
                                    ->label('Company'),
                                \Filament\Infolists\Components\TextEntry::make('start_date')
                                    ->date(),
                                \Filament\Infolists\Components\TextEntry::make('end_date')
                                    ->date(),
                                \Filament\Infolists\Components\TextEntry::make('status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'active' => 'success',
                                        'achieved' => 'info',
                                        'abandoned' => 'danger',
                                        default => 'gray',
                                    }),
                            ]),
                    ]),
            ]);
    }
}
