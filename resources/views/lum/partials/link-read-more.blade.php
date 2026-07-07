@php
    $classes = $classes ?? '';
    $lineWidth = $lineWidth ?? 79;
    $href = $href ?? '#';
    $lineTone = $lineTone ?? 'green';
    $asSpan = $asSpan ?? false;
    $tag = $asSpan ? 'span' : 'a';
@endphp

<{{ $tag }} @if (! $asSpan) href="{{ $href }}" @endif @class(['lum-link lum-link--read-more', $classes])>
    <span class="lum-link__text">{{ __('lum.blog.read_more') }}</span>
    <span class="lum-link__line mt-[4px]" style="width: {{ $lineWidth }}px">
        @if ($lineTone === 'rose')
            <img src="{{ $img('blog/underline-rose.svg') }}" alt="" class="lum-link__line-img" width="{{ $lineWidth }}" height="2">
        @else
            <img src="{{ $img('blog/underline.svg') }}" alt="" class="lum-link__line-img" width="{{ $lineWidth }}" height="2">
        @endif
    </span>
</{{ $tag }}>
