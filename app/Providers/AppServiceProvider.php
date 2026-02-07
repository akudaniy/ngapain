<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Filament\Forms\Components\DatePicker::configureUsing(fn (\Filament\Forms\Components\DatePicker $component) => $component->firstDayOfWeek(0));
        \Filament\Forms\Components\DateTimePicker::configureUsing(fn (\Filament\Forms\Components\DateTimePicker $component) => $component->firstDayOfWeek(0));
    }
}
