<?php

namespace App\Filament\Resources\KeyResults;

use App\Filament\Resources\KeyResults\Pages\CreateKeyResult;
use App\Filament\Resources\KeyResults\Pages\EditKeyResult;
use App\Filament\Resources\KeyResults\Pages\ListKeyResults;
use App\Filament\Resources\KeyResults\Schemas\KeyResultForm;
use App\Filament\Resources\KeyResults\Tables\KeyResultsTable;
use App\Models\KeyResult;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KeyResultResource extends Resource
{
    protected static ?string $model = KeyResult::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return KeyResultForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KeyResultsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKeyResults::route('/'),
            'create' => CreateKeyResult::route('/create'),
            'edit' => EditKeyResult::route('/{record}/edit'),
        ];
    }
}
