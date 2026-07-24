@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-primary text-start text-[14px] font-bold text-primary bg-primary-container/10 focus:outline-none focus:text-primary focus:bg-primary-container/20 focus:border-primary transition-colors duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-[14px] font-medium text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low hover:border-outline-variant focus:outline-none focus:text-on-surface focus:bg-surface-container-low focus:border-outline-variant transition-colors duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
