@php
    $network = $network ?? 'instagram';
    $href = $href ?? '#';
    $label = $label ?? __('lum.burger_footer.' . $network);
    $tone = $tone ?? 'dark';
@endphp

<a
    href="{{ $href }}"
    @class([
        'flex size-[32px] shrink-0 items-center justify-center rounded-full border',
        'border-lum-ivory' => $tone === 'dark',
        'border-lum-espresso' => $tone === 'light',
    ])
    aria-label="{{ $label }}"
>
    <img
        src="{{ $img("footer/{$network}.svg") }}"
        alt=""
        @class([
            'size-[18px]',
            'brightness-0' => $tone === 'light',
        ])
        width="18"
        height="18"
    >
</a>
