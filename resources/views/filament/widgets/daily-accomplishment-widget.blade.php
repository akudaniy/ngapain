<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Daily Accomplishment — {{ now()->format('M d, Y') }}
        </x-slot>

        <div class="space-y-4">
            @if ($accomplishment)
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $this->excerpt }}
                </div>

                <x-filament::button
                    tag="a"
                    href="{{ \App\Filament\Resources\DailyAccomplishments\DailyAccomplishmentResource::getUrl('edit', ['record' => $accomplishment]) }}"
                    size="sm"
                >
                    Edit Accomplishment
                </x-filament::button>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    You haven't recorded your daily accomplishment yet for today.
                </p>

                <x-filament::button
                    tag="a"
                    href="{{ \App\Filament\Resources\DailyAccomplishments\DailyAccomplishmentResource::getUrl('create') }}"
                    size="sm"
                >
                    Record Accomplishment
                </x-filament::button>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
