<?php

namespace App\Filament\Resources\Users\Infolists;

use App\Models\Task;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Details')
                    ->components([
                        TextEntry::make('name')
                            ->size(TextSize::Large)
                            ->weight(FontWeight::Bold),
                        TextEntry::make('email')
                            ->copyable(),
                        TextEntry::make('created_at')
                            ->label('Joined On')
                            ->dateTime(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                Section::make('Assigned Tasks')
                    ->description('Overview of all tasks assigned to this user.')
                    ->components([
                        RepeatableEntry::make('tasks')
                            ->schema([
                                TextEntry::make('name')
                                    ->weight(FontWeight::Bold)
                                    ->url(fn (Task $record) => \App\Filament\Resources\Tasks\TaskResource::getUrl('view', ['record' => $record])),
                                TextEntry::make('status')
                                    ->badge(),
                                TextEntry::make('due_at')
                                    ->dateTime()
                                    ->color('gray'),
                            ])
                            ->columns(3)
                            ->grid(1)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Daily Achievements')
                    ->description('Recent accomplishments recorded by the user.')
                    ->components([
                        RepeatableEntry::make('dailyAccomplishments')
                            ->label('')
                            ->schema([
                                TextEntry::make('date')
                                    ->date()
                                    ->weight(FontWeight::Bold)
                                    ->url(fn ($record) => \App\Filament\Resources\DailyAccomplishments\DailyAccomplishmentResource::getUrl('view', ['record' => $record])),
                                TextEntry::make('content')
                                    ->markdown()
                                    ->limit(150),
                            ])
                            ->columns(1)
                            ->grid(2)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
