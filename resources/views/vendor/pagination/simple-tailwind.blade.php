@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex gap-2 items-center justify-between">

        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center px-4 py-2 text-[13px] font-bold text-on-surface-variant/50 bg-surface-container-low border border-outline-variant cursor-not-allowed leading-5 rounded-lg">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-[13px] font-bold text-on-surface bg-surface border border-outline-variant leading-5 rounded-lg hover:bg-surface-container-highest transition-colors">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-[13px] font-bold text-on-surface bg-surface border border-outline-variant leading-5 rounded-lg hover:bg-surface-container-highest transition-colors">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="inline-flex items-center px-4 py-2 text-[13px] font-bold text-on-surface-variant/50 bg-surface-container-low border border-outline-variant cursor-not-allowed leading-5 rounded-lg">
                {!! __('pagination.next') !!}
            </span>
        @endif

    </nav>
@endif
