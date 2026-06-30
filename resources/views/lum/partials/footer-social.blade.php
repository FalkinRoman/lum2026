@php
    $network = $network ?? 'instagram';
    $href = $href ?? '#';
    $label = $label ?? __('lum.burger_footer.' . $network);
@endphp

<a
    href="{{ $href }}"
    class="flex size-[32px] shrink-0 items-center justify-center rounded-full border border-lum-ivory"
    aria-label="{{ $label }}"
>
    <img
        src="{{ $img("footer/{$network}.svg") }}"
        alt=""
        class="size-[18px]"
        width="18"
        height="18"
    >
</a>
