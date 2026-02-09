<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\Task;
use App\Models\DailyAccomplishment;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Carbon;

class UserDailyActivity extends Page
{
    protected static string $resource = UserResource::class;

    protected string $view = 'filament.resources.users.pages.user-daily-activity';

    public $record;
    public $date;

    public function mount($record, $date)
    {
        $this->record = \App\Models\User::findOrFail($record);
        $this->date = $date;
    }

    public function getHeading(): string
    {
        return "Daily Activity: " . Carbon::parse($this->date)->format('F j, Y');
    }

    public function getBreadcrumbs(): array
    {
        return [
            UserResource::getUrl('index') => __('filament-panels::resources/pages/list-records.breadcrumb'),
            UserResource::getUrl('view', ['record' => $this->record]) => $this->record->name,
            '#' => 'Daily Activity',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('previous_day')
                ->label('Previous Day')
                ->icon('heroicon-m-chevron-left')
                ->color('gray')
                ->url(fn () => UserResource::getUrl('stats', [
                    'record' => $this->record,
                    'date' => Carbon::parse($this->date)->subDay()->toDateString(),
                ])),
            \Filament\Actions\Action::make('select_date')
                ->label('Select Date')
                ->icon('heroicon-m-calendar')
                ->form([
                    \Filament\Forms\Components\DatePicker::make('date')
                        ->default($this->date)
                        ->required(),
                ])
                ->action(function (array $data) {
                    return redirect(UserResource::getUrl('stats', [
                        'record' => $this->record,
                        'date' => $data['date'],
                    ]));
                }),
            \Filament\Actions\Action::make('next_day')
                ->label('Next Day')
                ->icon('heroicon-m-chevron-right')
                ->color('gray')
                ->iconPosition(\Filament\Support\Enums\IconPosition::After)
                ->url(fn () => UserResource::getUrl('stats', [
                    'record' => $this->record,
                    'date' => Carbon::parse($this->date)->addDay()->toDateString(),
                ])),
        ];
    }

    protected function getViewData(): array
    {
        $date = Carbon::parse($this->date);

        // Tasks completed on this day
        $tasks = Task::with('project')
            ->where('assigned_user_id', $this->record->id)
            ->whereDate('completed_at', $date)
            ->get();

        // Accomplishments recorded on this day
        $accomplishments = DailyAccomplishment::where('user_id', $this->record->id)
            ->whereDate('date', $date)
            ->get();

        return [
            'tasks' => $tasks,
            'accomplishments' => $accomplishments,
        ];
    }
}
