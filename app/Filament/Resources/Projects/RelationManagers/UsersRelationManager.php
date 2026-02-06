<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $title = 'Project Members';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('role')
                    ->options([
                        'manager' => 'Manager',
                        'member' => 'Member',
                    ])
                    ->required()
                    ->default('member'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'manager' => 'primary',
                        'member' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->authorize(fn () => $this->isProjectManager())
                    ->recordSelectOptionsQuery(fn ($query) => $query->whereDoesntHave('roles', fn ($q) => $q->where('name', 'super_admin')))
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name', 'email'])
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Select::make('role')
                            ->options([
                                'manager' => 'Manager',
                                'member' => 'Member',
                            ])
                            ->required()
                            ->default('member'),
                    ]),
            ])
            ->actions([
                EditAction::make()
                    ->authorize(fn () => $this->isProjectManager()),
                DetachAction::make()
                    ->authorize(fn () => $this->isProjectManager()),
            ]);
    }

    protected function isProjectManager(): bool
    {
        return $this->getOwnerRecord()->users()
            ->where('users.id', auth()->id())
            ->wherePivot('role', 'manager')
            ->exists();
    }
}
