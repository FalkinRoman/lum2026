@php
    $label = $label ?? 'Link';
    $href = $href ?? '#';
    $classes = $classes ?? '';
    $target = $target ?? null;
    $rel = $rel ?? null;
    $variant = $variant ?? 'flip';
    $underlineTone = $underlineTone ?? 'ivory';
@endphp

@if ($variant === 'line')
    <a
        href="{{ $href }}"
        @class(['lum-link lum-link--footer lum-link--footer-line', $classes])
        @if($target) target="{{ $target }}" @endif
        @if($rel) rel="{{ $rel }}" @endif
    >
        <span class="lum-link__text">{{ $label }}</span>
        @include('lum.partials.link-underline', [
            'tone' => $underlineTone,
            'fullWidth' => true,
            'graphicClass' => 'mt-0',
        ])
    </a>
@else
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
        @include('lum.partials.link-underline', [
            'tone' => $underlineTone,
            'fullWidth' => true,
            'graphicClass' => 'mt-0',
        ])
    </a>
@endif
