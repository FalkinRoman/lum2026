@php
    $label = $label ?? 'Link';
    $href = $href ?? '#';
    $classes = $classes ?? '';
    $target = $target ?? null;
    $rel = $rel ?? null;
@endphp

<a
    href="{{ $href }}"
    @class(['lum-link lum-link--footer', $classes])
    data-text="{{ $label }}"
    @if($target) target="{{ $target }}" @endif
    @if($rel) rel="{{ $rel }}" @endif
>
    <span class="lum-link__flip">
        <span class="lum-link__text">{{ $label }}</span>
        <span class="lum-link__text lum-link__text--ghost" aria-hidden="true">{{ $label }}</span>
    </span>
    <span class="lum-link__line lum-link__line--footer">
        <img src="{{ $img('footer/link-underline.svg') }}" alt="" class="lum-link__line-img" width="108" height="2">
    </span>
</a>
