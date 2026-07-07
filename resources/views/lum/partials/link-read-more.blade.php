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
    @include('lum.partials.link-underline', [
        'width' => $lineWidth,
        'tone' => $lineTone,
    ])
</{{ $tag }}>
