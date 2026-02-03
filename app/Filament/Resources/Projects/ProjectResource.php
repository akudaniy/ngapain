<?php

namespace App\Filament\Resources\Projects;

use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Filament\Resources\Projects\Pages\ViewProject;
use App\Filament\Resources\Projects\RelationManagers\TasksRelationManager;
use App\Filament\Resources\Projects\Schemas\ProjectForm;
use App\Filament\Resources\Projects\Tables\ProjectsTable;
use App\Models\Project;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ProjectForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjectsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class,
            RelationManagers\TasksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'view' => ViewProject::route('/{record}'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }

    public static function infolist(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Project Details')
                    ->components([
                        \Filament\Infolists\Components\TextEntry::make('name')
                            ->size(\Filament\Support\Enums\TextSize::Large)
                            ->weight(\Filament\Support\Enums\FontWeight::Bold)
                            ->columnSpanFull(),

                        \Filament\Schemas\Components\Grid::make(3)
                            ->components([
                                \Filament\Infolists\Components\TextEntry::make('created_at')
                                    ->label('Created On')
                                    ->dateTime(),
                                \Filament\Infolists\Components\TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime(),
                            ]),
                    ]),

                \Filament\Schemas\Components\Section::make('Statistics')
                    ->components([
                        \Filament\Infolists\Components\TextEntry::make('tasks_count')
                            ->state(function (Project $record): int {
                                return $record->tasks()->count();
                            })
                            ->label('Total Tasks'),
                        \Filament\Infolists\Components\TextEntry::make('users_count')
                            ->state(function (Project $record): int {
                                return $record->users()->count();
                            })
                            ->label('Team Size'),
                    ])->columns(2),
            ]);
    }
}
