@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-bold text-[13px] text-secondary flex items-center gap-2']) }}>
        <span class="material-symbols-outlined text-[18px]">check_circle</span>
        {{ $status }}
    </div>
@endif
