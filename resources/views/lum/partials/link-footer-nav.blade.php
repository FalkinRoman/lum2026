@php
    $label = $label ?? 'Link';
    $classes = $classes ?? '';
@endphp

<a href="#" @class(['lum-link lum-link--footer', $classes]) data-text="{{ $label }}">
    <span class="lum-link__flip">
        <span class="lum-link__text">{{ $label }}</span>
        <span class="lum-link__text lum-link__text--ghost" aria-hidden="true">{{ $label }}</span>
    </span>
    <span class="lum-link__line lum-link__line--footer">
        <img src="{{ $img('footer/link-underline.svg') }}" alt="" class="lum-link__line-img" width="108" height="2">
    </span>
</a>
