@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">

        <div class="flex gap-2 items-center justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-[13px] font-bold text-on-surface-variant bg-surface-container-lowest border border-outline-variant cursor-not-allowed leading-5 rounded-xl">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-[13px] font-bold text-on-surface bg-surface-container-lowest border border-outline-variant leading-5 rounded-xl hover:text-primary hover:bg-surface-container focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary active:bg-surface-container-high transition ease-in-out duration-150">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-[13px] font-bold text-on-surface bg-surface-container-lowest border border-outline-variant leading-5 rounded-xl hover:text-primary hover:bg-surface-container focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary active:bg-surface-container-high transition ease-in-out duration-150">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-[13px] font-bold text-on-surface-variant bg-surface-container-lowest border border-outline-variant cursor-not-allowed leading-5 rounded-xl">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:gap-4 sm:items-center sm:justify-between">
            <div>
                <p class="text-[13px] text-on-surface-variant leading-5">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-bold text-on-surface">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-bold text-on-surface">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-bold text-on-surface">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="inline-flex rtl:flex-row-reverse shadow-sm rounded-xl overflow-hidden">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="inline-flex items-center px-2 py-2 text-sm font-medium text-on-surface-variant bg-surface-container-lowest border border-outline-variant cursor-not-allowed leading-5" aria-hidden="true">
                                <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-2 py-2 text-sm font-medium text-on-surface bg-surface-container-lowest border border-outline-variant leading-5 hover:text-primary hover:bg-surface-container focus:outline-none focus:ring-1 focus:ring-primary active:bg-surface-container-high transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">
                            <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="inline-flex items-center px-4 py-2 -ml-px text-[13px] font-bold text-on-surface-variant bg-surface-container-lowest border border-outline-variant cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="inline-flex items-center px-4 py-2 -ml-px text-[13px] font-bold text-white bg-primary border border-primary cursor-default leading-5 shadow-inner">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center px-4 py-2 -ml-px text-[13px] font-bold text-on-surface bg-surface-container-lowest border border-outline-variant leading-5 hover:text-primary hover:bg-surface-container focus:outline-none focus:ring-1 focus:ring-primary active:bg-surface-container-high transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-on-surface bg-surface-container-lowest border border-outline-variant leading-5 hover:text-primary hover:bg-surface-container focus:outline-none focus:ring-1 focus:ring-primary active:bg-surface-container-high transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
                            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-on-surface-variant bg-surface-container-lowest border border-outline-variant cursor-not-allowed leading-5" aria-hidden="true">
                                <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
