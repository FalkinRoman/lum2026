@php
    $network = $network ?? 'instagram';
    $href = $href ?? '#';
    $label = $label ?? __('lum.burger_footer.' . $network);
    $tone = $tone ?? 'dark';
@endphp

<a
    href="{{ $href }}"
    @class([
        'lum-btn-pan flex size-[36px] shrink-0 items-center justify-center rounded-full p-[2px]',
        'lum-btn-pan--ivory' => $tone === 'dark',
        'lum-btn-pan--espresso' => $tone === 'light',
    ])
    aria-label="{{ $label }}"
>
    <img
        src="{{ $img("footer/{$network}.svg") }}"
        alt=""
        class="size-[32px]"
        width="32"
        height="32"
    >
</a>
