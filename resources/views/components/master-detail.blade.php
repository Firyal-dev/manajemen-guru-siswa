{{-- Master-detail layout: table on left, detail panel on right. Alpine.js tracks selected item. --}}
@props(['placeholder' => 'Pilih data untuk melihat detail'])

<div x-data="{ selected: null }" class="flex items-start gap-6">
    {{-- Left: Table --}}
    <div class="w-2/3">
        <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden">
            <div class="p-6">
                {{ $table }}
            </div>
        </div>
    </div>

    {{-- Right: Detail Panel --}}
    <div class="w-1/3">
        <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden">
            <div class="p-6">
                {{-- Empty State --}}
                <div x-show="!selected"
                    class="flex flex-col items-center justify-center h-64 text-on-surface-variant">
                    <span class="material-symbols-outlined text-[48px] opacity-20 mb-3">search_off</span>
                    <span class="text-[14px]">{{ $placeholder }}</span>
                </div>

                {{-- Detail Content --}}
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
