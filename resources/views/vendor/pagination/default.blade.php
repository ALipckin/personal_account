<div class="pagination">
    <div class="pages">
        @if ($paginator->onFirstPage())
            <a>
                <img src="{{ asset('image/arrow-today.svg') }}" class="disabled" alt="Previous">
            </a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">
                <img src="{{ asset('image/arrow-today.svg') }}" alt="Previous">
            </a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="no-active">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">
                <img class="last" src="{{ asset('image/arrow-today.svg') }}" alt="Next">
            </a>
        @else
            <a>
                <img src="{{ asset('image/arrow-today.svg') }}" class="disabled last" alt="Next">
            </a>
        @endif
    </div>

    <div class="counts">
        <span>Показывать по:</span>
        @foreach ([10, 20, 50] as $count)
            @if ($count == request('per_page')) {{-- Укажите значение по умолчанию --}}
            <span class="count active">{{ $count }}</span>
            @else
                <a class="count" href="{{ request()->fullUrlWithQuery(['per_page' => $count]) }}">{{ $count }}</a>
            @endif
        @endforeach
    </div>
</div>
