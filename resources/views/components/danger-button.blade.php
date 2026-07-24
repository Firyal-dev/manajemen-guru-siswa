<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 px-4 py-2.5 bg-error-container/10 border border-error-container rounded-lg font-bold text-[14px] text-error hover:bg-error-container/20 focus:outline-none focus:ring-1 focus:ring-error focus:ring-offset-2 transition-colors']) }}>
    {{ $slot }}
</button>
