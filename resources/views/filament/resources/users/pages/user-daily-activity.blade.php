<x-filament-panels::page>
    <div class="space-y-6">
        <section class="p-6 bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800">
            <h3 class="text-xl font-bold mb-4 flex items-center">
                <x-heroicon-o-check-circle class="w-6 h-6 mr-2 text-primary-500" />
                Tasks Completed
            </h3>

            @if($tasks->isEmpty())
                <p class="text-gray-500 dark:text-gray-400 italic">No tasks were marked as completed on this day.</p>
            @else
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($tasks as $task)
                        <div class="p-4 border border-gray-100 dark:border-gray-800 rounded-lg hover:border-primary-200 dark:hover:border-primary-800 transition-colors">
                            <div class="text-xs text-gray-400 mb-1">{{ $task->project?->name }}</div>
                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $task->name }}</h4>
                            <div class="flex items-center text-xs text-gray-500">
                                <x-heroicon-o-clock class="w-4 h-4 mr-1" />
                                Completed {{ $task->completed_at->format('H:i') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="p-6 bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800">
            <h3 class="text-xl font-bold mb-4 flex items-center">
                <x-heroicon-o-fire class="w-6 h-6 mr-2 text-orange-500" />
                Daily Accomplishments
            </h3>

            @if($accomplishments->isEmpty())
                <p class="text-gray-500 dark:text-gray-400 italic">No daily accomplishments were recorded on this day.</p>
            @else
                <div class="space-y-6">
                    @foreach($accomplishments as $acc)
                        <div class="prose dark:prose-invert max-w-none">
                            {!! Str::markdown($acc->content) !!}
                        </div>
                        @if($acc->tasks_completed_snapshot)
                             <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div class="text-xs font-bold text-gray-400 uppercase mb-2">Tasks Snapshot</div>
                                <ul class="list-disc list-inside text-sm text-gray-600 dark:text-gray-400">
                                    @foreach($acc->tasks_completed_snapshot as $snapshot)
                                        <li>{{ $snapshot['name'] ?? 'Unknown' }}</li>
                                    @endforeach
                                </ul>
                             </div>
                        @endif
                        @if(!$loop->last)
                            <hr class="border-gray-100 dark:border-gray-800" />
                        @endif
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</x-filament-panels::page>
