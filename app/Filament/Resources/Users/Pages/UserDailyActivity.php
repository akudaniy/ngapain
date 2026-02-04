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
