<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 px-4 py-2.5 bg-primary border border-transparent rounded-lg font-bold text-[14px] text-white hover:bg-primary/90 focus:outline-none focus:ring-1 focus:ring-primary focus:ring-offset-2 transition-colors shadow-sm']) }}>
    {{ $slot }}
</button>
