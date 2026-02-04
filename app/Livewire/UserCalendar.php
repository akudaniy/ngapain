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

        while ($currentDate <= $endDate) {
            $daysInMonth[] = [
                'date' => $currentDate->toDateString(),
                'day' => $currentDate->day,
                'isCurrentMonth' => $currentDate->month === (int)$this->month,
                'isToday' => $currentDate->isToday(),
            ];
            $currentDate->addDay();
        }

        return view('livewire.user-calendar', [
            'days' => $daysInMonth,
            'monthName' => $startOfMonth->format('F Y'),
        ]);
    }
}
