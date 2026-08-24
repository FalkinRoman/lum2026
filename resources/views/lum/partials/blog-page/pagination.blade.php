@props([
    'paginator',
])

@if ($paginator->hasPages())
    @php
        $img = $img ?? fn (string $path) => \App\Support\Content::mediaUrl($path);
    @endphp

    <nav class="lum-blog-pagination" aria-label="{{ __('lum.blog.pagination_label') }}">
        @if ($paginator->onFirstPage())
            <span class="lum-blog-pagination__arrow is-disabled" aria-disabled="true">
                <img src="{{ $img('ui/carousel-arrow-left.svg') }}" alt="" width="24" height="24">
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="lum-blog-pagination__arrow" rel="prev" aria-label="{{ __('lum.blog.pagination_prev') }}">
                <img src="{{ $img('ui/carousel-arrow-left.svg') }}" alt="" width="24" height="24">
            </a>
        @endif

        <div class="lum-blog-pagination__pages">
            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if ($page === $paginator->currentPage())
                    <span class="lum-blog-pagination__page is-active" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="lum-blog-pagination__page">{{ $page }}</a>
                @endif
            @endforeach
        </div>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="lum-blog-pagination__arrow" rel="next" aria-label="{{ __('lum.blog.pagination_next') }}">
                <img src="{{ $img('ui/carousel-arrow-right.svg') }}" alt="" width="24" height="24">
            </a>
        @else
            <span class="lum-blog-pagination__arrow is-disabled" aria-disabled="true">
                <img src="{{ $img('ui/carousel-arrow-right.svg') }}" alt="" width="24" height="24">
            </span>
        @endif
    </nav>
@endif
