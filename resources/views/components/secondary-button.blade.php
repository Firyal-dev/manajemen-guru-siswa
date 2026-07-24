<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center gap-2 px-4 py-2.5 bg-surface-container-high border border-outline-variant/50 rounded-lg font-bold text-[14px] text-primary shadow-sm hover:bg-surface-container-highest focus:outline-none focus:ring-1 focus:ring-primary focus:ring-offset-2 disabled:opacity-25 transition-colors']) }}>
    {{ $slot }}
</button>
