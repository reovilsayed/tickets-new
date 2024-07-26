@if ($paginator->hasPages())
<div class="row">
    <nav class="col-md-12 text-center">
        <ul class="news-pagination-wrap align-center mb-30 mt-30">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class=" disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <i class="ti-angle-left"></i>
                </li>
            @else
                <li class="">
                    <a class="" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="ti-angle-left"></i></a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class=" disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class=""><a class="" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="">
                    <a class="" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="ti-angle-right"></i></a>
                </li>
            @else
                <li class=" disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="" aria-hidden="true"><i class="ti-angle-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
</div>
@endif

