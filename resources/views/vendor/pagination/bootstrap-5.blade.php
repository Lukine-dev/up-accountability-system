@if ($paginator->hasPages())
    <div class="my-4 py-3 px-3 bg-white rounded shadow-sm border">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">

            {{-- Pagination Info --}}
            <div class="text-muted small">
                Showing 
                <span class="fw-semibold text-dark">{{ $paginator->firstItem() }}</span> 
                to 
                <span class="fw-semibold text-dark">{{ $paginator->lastItem() }}</span> 
                of 
                <span class="fw-semibold text-dark">{{ $paginator->total() }}</span> 
                results
            </div>

            {{-- Pagination Controls --}}
            <nav>
                <ul class="pagination mb-0">
                    {{-- Previous Page --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link border-0 text-muted">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link text-white bg-maroon border-0" href="{{ $paginator->previousPageUrl() }}">&lsaquo;</a>
                        </li>
                    @endif

                    {{-- Pagination Links --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="page-item disabled"><span class="page-link text-muted">{{ $element }}</span></li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link border-0 text-white" style="background-color: #90143c;">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link text-maroon border-0" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link text-white bg-maroon border-0" href="{{ $paginator->nextPageUrl() }}">&rsaquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link border-0 text-muted">&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
@endif

<style>
    .bg-maroon {
    background-color: #90143c !important;
}

.text-maroon {
    color: #90143c !important;
}

.page-link:hover {
    background-color: #90143c !important;
    color: #fff !important;
}
</style>