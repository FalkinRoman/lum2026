@php
    $href = $href ?? '#';
    $label = $label ?? '';
    $active = $active ?? false;
    $showDot = $showDot ?? true;
@endphp

<a href="{{ $href }}" @class(['lum-nav-link lum-nav-link--inline', 'is-active' => $active])>
    <span class="lum-nav-link__label">
        <span class="lum-nav-link__slide">
            <span class="lum-nav-link__text">{{ $label }}</span>
            <span class="lum-nav-link__text" aria-hidden="true">{{ $label }}</span>
        </span>
    </span>
    @if ($showDot)
        <span class="lum-nav-link__dot" aria-hidden="true"></span>
    @endif
</a>
