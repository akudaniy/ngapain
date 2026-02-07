<?php

namespace App\Filament\Resources\Tasks\Infolists;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class TaskInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Task Information')
                    ->components([
                        TextEntry::make('name')
                            ->weight(FontWeight::Bold),
                        TextEntry::make('project.name')
                            ->label('Project'),
                        TextEntry::make('assignedUser.name')
                            ->label('Assigned To'),
                        TextEntry::make('status')
                            ->badge(),
                        TextEntry::make('effort_score')
                            ->label('Effort'),
                        TextEntry::make('due_at')
                            ->label('Due Date')
                            ->dateTime('M d, Y H:i'),
                    ])
                    ->columns(3),

                Section::make('Description')
                    ->components([
                        TextEntry::make('description')
                            ->markdown()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
