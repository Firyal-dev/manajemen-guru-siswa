@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all disabled:opacity-50']) }}>
