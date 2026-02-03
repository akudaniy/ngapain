<?php

namespace App\Filament\Resources\DailyAccomplishments\Schemas;

use App\Models\Task;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class DailyAccomplishmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(auth()->id())
                    ->disabled()
                    ->dehydrated(),
                Select::make('company_id')
                    ->relationship('company', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                DatePicker::make('date')
                    ->default(now())
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Set $set, $state) => self::updateTaskSnapshot($set, $state)),
                MarkdownEditor::make('content')
                    ->required()
                    ->disableToolbarButtons([
                        'attachFiles',
                    ])
                    ->columnSpanFull(),
                Placeholder::make('tasks_completed_today')
                    ->label('Tasks Completed Today')
                    ->content(fn ($get) => self::getTasksCompletedToday($get('date'))),
            ]);
    }

    protected static function updateTaskSnapshot(Set $set, $date): void
    {
        if (!$date) return;

        $tasks = Task::query()
            ->where('assigned_user_id', auth()->id())
            ->where('status', 'done')
            ->whereDate('completed_at', $date)
            ->get(['id', 'name'])
            ->toArray();

        $set('tasks_completed_snapshot', $tasks);
    }

    protected static function getTasksCompletedToday($date): HtmlString
    {
        if (!$date) return new HtmlString('Select a date to see completed tasks.');

        $tasks = Task::query()
            ->where('assigned_user_id', auth()->id())
            ->where('status', 'done')
            ->whereDate('completed_at', $date)
            ->pluck('name');

        if ($tasks->isEmpty()) {
            return new HtmlString('No tasks completed on this date.');
        }

        $list = $tasks->map(fn ($task) => "<li>{$task}</li>")->implode('');

        return new HtmlString("<ul class='list-disc list-inside'>{$list}</ul>");
    }
}
