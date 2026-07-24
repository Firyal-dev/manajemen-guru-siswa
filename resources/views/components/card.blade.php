{{-- Reusable card container with consistent styling --}}
@props([])

<div {{ $attributes->merge(['class' => 'bg-surface rounded-xl border border-outline-variant card-shadow p-6']) }}>
    {{ $slot }}
</div>
