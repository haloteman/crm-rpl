<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-wrap items-center gap-3">
    <span class="text-xs text-slate-500">{{ $paginator->perPage() }} per halaman</span>

    <div class="flex items-center gap-1.5">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="pager-btn pointer-events-none text-slate-300" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                <x-icon name="chevron-left" class="size-4" />
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pager-btn" aria-label="{{ __('pagination.previous') }}">
                <x-icon name="chevron-left" class="size-4" />
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-1 text-xs text-slate-400" aria-disabled="true">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pager-btn pager-btn-active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pager-btn" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pager-btn" aria-label="{{ __('pagination.next') }}">
                <x-icon name="chevron-right" class="size-4" />
            </a>
        @else
            <span class="pager-btn pointer-events-none text-slate-300" aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                <x-icon name="chevron-right" class="size-4" />
            </span>
        @endif
    </div>
</nav>