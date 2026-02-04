<div class="calendar-container p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $monthName }}</h3>
        <div class="flex space-x-2">
            <button wire:click="previousMonth" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors border border-gray-200 dark:border-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
            <button wire:click="nextMonth" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors border border-gray-200 dark:border-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-7 gap-px bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 shadow-inner">
        @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
            <div class="bg-gray-50 dark:bg-gray-800 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                {{ $dayName }}
            </div>
        @endforeach

        @foreach($days as $day)
            @php
                $url = \App\Filament\Resources\Users\UserResource::getUrl('stats', ['record' => $user, 'date' => $day['date']]);
            @endphp
            <a
                href="{{ $url }}"
                class="calendar-grid-cell
                {{ !$day['isCurrentMonth'] ? 'opacity-50 text-gray-400 dark:text-gray-600' : '' }}
                {{ $day['isToday'] ? 'z-10 ring-2 ring-primary-500 ring-inset' : '' }}"
            >
                <div class="flex items-center justify-between">
                    <time datetime="{{ $day['date'] }}" class="{{ $day['isToday'] ? 'bg-primary-500 text-white rounded-full w-7 h-7' : 'text-gray-700 dark:text-gray-300' }} flex items-center justify-center text-sm font-semibold">
                        {{ $day['day'] }}
                    </time>
                </div>

                <div class="mt-2 space-y-1">
                    @if($day['hasTasks'])
                        <div class="flex items-center text-[10px] text-green-600 dark:text-green-500 font-bold" title="{{ $day['taskCount'] }} tasks completed">
                            <x-heroicon-o-check-circle class="w-3 h-3 mr-1" />
                            <span>{{ $day['taskCount'] }} Done</span>
                        </div>
                    @endif

                    @if($day['hasAccomplishment'])
                        <div class="flex items-center text-[10px] text-amber-600 dark:text-amber-500 font-bold" title="Daily accomplishment recorded">
                            <x-heroicon-o-sparkles class="w-3 h-3 mr-1" />
                            <span>Pulse Entry</span>
                        </div>
                    @endif
                </div>

                <div class="mt-auto pt-2 text-[9px] text-gray-400 group-hover:text-primary-500 transition-colors uppercase font-medium">
                    View Activity
                </div>
            </a>
        @endforeach
    </div>
</div>
