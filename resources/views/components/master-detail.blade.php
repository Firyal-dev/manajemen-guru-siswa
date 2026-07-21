{{-- Master-detail layout: table on left, detail panel on right. Alpine.js tracks selected item. --}}
@props(['placeholder' => 'Pilih data untuk melihat detail'])

<div x-data="{ selected: null }" class="flex items-start gap-6">
    {{-- Left: Table --}}
    <div class="w-2/3">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                {{ $table }}
            </div>
        </div>
    </div>

    {{-- Right: Detail Panel --}}
    <div class="w-1/3">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                {{-- Empty State --}}
                <div x-show="!selected"
                    class="flex flex-col items-center justify-center h-64 text-gray-400 dark:text-gray-500">
                    <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                    </svg>
                    <span>{{ $placeholder }}</span>
                </div>

                {{-- Detail Content --}}
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
