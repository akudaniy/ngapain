<?php

namespace App\Filament\Resources\DailyAccomplishments;

use App\Filament\Resources\DailyAccomplishments\Pages\CreateDailyAccomplishment;
use App\Filament\Resources\DailyAccomplishments\Pages\EditDailyAccomplishment;
use App\Filament\Resources\DailyAccomplishments\Pages\ListDailyAccomplishments;
use App\Filament\Resources\DailyAccomplishments\Pages\ViewDailyAccomplishment;
use App\Filament\Resources\DailyAccomplishments\Schemas\DailyAccomplishmentForm;
use App\Filament\Resources\DailyAccomplishments\Tables\DailyAccomplishmentsTable;
use App\Filament\Resources\DailyAccomplishments\Infolists\DailyAccomplishmentInfolist;
use App\Models\DailyAccomplishment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DailyAccomplishmentResource extends Resource
{
    protected static ?string $model = DailyAccomplishment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return DailyAccomplishmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DailyAccomplishmentsTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DailyAccomplishmentInfolist::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()?->hasAnyRole(['super_admin', 'manager'])) {
            return $query;
        }

        return $query->where('user_id', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDailyAccomplishments::route('/'),
            'create' => CreateDailyAccomplishment::route('/create'),
            'view' => ViewDailyAccomplishment::route('/{record}'),
            'edit' => EditDailyAccomplishment::route('/{record}/edit'),
        ];
    }
}
