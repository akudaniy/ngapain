<?php

namespace App\Filament\Resources\DailyAccomplishments\Infolists;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class DailyAccomplishmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->components([
                        TextEntry::make('user.name')
                            ->label('User')
                            ->weight(FontWeight::Bold),
                        TextEntry::make('company.name')
                            ->label('Company'),
                        TextEntry::make('date')
                            ->date()
                            ->weight(FontWeight::Bold),
                    ])
                    ->columns(3),

                Section::make('Accomplishment Content')
                    ->components([
                        TextEntry::make('content')
                            ->markdown()
                            ->columnSpanFull(),
                    ]),

                Section::make('Completed Tasks Archive')
                    ->description('Snapshot of tasks marked as "done" when this accomplishment was recorded.')
                    ->components([
                        TextEntry::make('tasks_completed_snapshot')
                            ->label('')
                            ->formatStateUsing(function ($state) {
                                if (!$state || !is_array($state)) {
                                    return 'No tasks were captured in the snapshot.';
                                }

                                $list = collect($state)
                                    ->map(fn ($task) => "<li>" . ($task['name'] ?? 'Unknown Task') . "</li>")
                                    ->implode('');

                                return "<ul class='list-disc list-inside p-2 bg-gray-50 dark:bg-gray-800 rounded-lg'>{$list}</ul>";
                            })
                            ->html()
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
