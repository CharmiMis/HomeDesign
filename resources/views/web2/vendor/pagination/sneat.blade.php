@if ($paginator->hasPages())
    <div class="ai-upload-latest-pagination">
        <ul>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled">
                    <a class="ai-upload-latest-prev new-page-link" href="javascript:void(0);">Prev</a>
                </li>
            @else
                <li>
                    <a class="ai-upload-latest-prev new-page-link" data-url="{{ $paginator->previousPageUrl() }}" href="javascript:void(0);">Prev</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page">
                                <a class="ai-upload-latest-link new-page-link" data-url="{{ $url }}" href="javascript:void(0);">{{ $page }}</a>
                            </li>
                        @else
                            <li>
                                <a class="ai-upload-latest-link new-page-link" data-url="{{ $url }}" href="javascript:void(0);">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="ai-upload-latest-next new-page-link" data-url="{{ $paginator->nextPageUrl() }}" href="javascript:void(0);">Next</a>
                </li>
            @else
                <li class="disabled">
                    <a class="ai-upload-latest-next new-page-link" href="javascript:void(0);">Next</a>
                </li>
            @endif
        </ul>
    </div>
@endif
