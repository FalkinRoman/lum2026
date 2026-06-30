@php
    $classes = $classes ?? '';
    $lineWidth = $lineWidth ?? 79;
@endphp

<a href="#" @class(['lum-link lum-link--read-more', $classes])>
    <span class="lum-link__text">{{ __('lum.blog.read_more') }}</span>
    <span class="lum-link__line mt-[4px]" style="width: {{ $lineWidth }}px">
        <img src="{{ $img('blog/underline.svg') }}" alt="" class="lum-link__line-img" width="{{ $lineWidth }}" height="2">
    </span>
</a>
