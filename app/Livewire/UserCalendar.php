<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class UserCalendar extends Component
{
    public User $user;
    public $year;
    public $month;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->year = now()->year;
        $this->month = now()->month;
    }

    public function previousMonth()
    {
        $date = Carbon::create($this->year, $this->month, 1)->subMonth();
        $this->year = $date->year;
        $this->month = $date->month;
    }

    public function nextMonth()
    {
        $date = Carbon::create($this->year, $this->month, 1)->addMonth();
        $this->year = $date->year;
        $this->month = $date->month;
    }

    public function render()
    {
        $startOfMonth = Carbon::create($this->year, $this->month, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $daysInMonth = [];
        $currentDate = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $endDate = $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY);

        // Fetch activity indicators
        $tasksDone = $this->user->tasks()
            ->where('status', 'done')
            ->whereBetween('completed_at', [$currentDate->toDateTimeString(), $endDate->toDateTimeString()])
            ->selectRaw('DATE(completed_at) as date, count(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $accomplishments = $this->user->dailyAccomplishments()
            ->whereBetween('date', [$currentDate->toDateString(), $endDate->toDateString()])
            ->pluck('id', 'date');

        while ($currentDate <= $endDate) {
            $dateString = $currentDate->toDateString();
            $daysInMonth[] = [
                'date' => $dateString,
                'day' => $currentDate->day,
                'isCurrentMonth' => $currentDate->month === (int)$this->month,
                'isToday' => $currentDate->isToday(),
                'hasTasks' => isset($tasksDone[$dateString]),
                'taskCount' => $tasksDone[$dateString] ?? 0,
                'hasAccomplishment' => isset($accomplishments[$dateString]),
            ];
            $currentDate->addDay();
        }

        return view('livewire.user-calendar', [
            'days' => $daysInMonth,
            'monthName' => $startOfMonth->format('F Y'),
        ]);
    }
}
