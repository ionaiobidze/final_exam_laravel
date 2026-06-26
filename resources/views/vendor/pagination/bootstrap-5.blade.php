@if ($paginator->hasPages())
<nav aria-label="Pagination" class="hig-pagination">
  {{-- Previous --}}
  @if ($paginator->onFirstPage())
    <span style="color: var(--hig-gray-2);">&lsaquo;</span>
  @else
    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous">&lsaquo;</a>
  @endif

  {{-- Page numbers --}}
  @foreach ($elements as $element)
    @if (is_string($element))
      <span style="color: var(--hig-gray-2);">{{ $element }}</span>
    @endif
    @if (is_array($element))
      @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
          <span class="page-link active" aria-current="page">{{ $page }}</span>
        @else
          <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        @endif
      @endforeach
    @endif
  @endforeach

  {{-- Next --}}
  @if ($paginator->hasMorePages())
    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next">&rsaquo;</a>
  @else
    <span style="color: var(--hig-gray-2);">&rsaquo;</span>
  @endif
</nav>
@endif
