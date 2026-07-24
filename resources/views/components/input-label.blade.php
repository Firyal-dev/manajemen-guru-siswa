@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-[13px] font-bold text-on-surface mb-2']) }}>
    {{ $value ?? $slot }}
</label>
