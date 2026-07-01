{{--
    Триггер для sticky-header. Ставить сразу после inline-хедера.
    На главной роль триггера играет CTA в hero (data-lum-sticky-trigger).
--}}
@php
    $mobileTop = $mobileTop ?? 80;
    $tabletTop = $tabletTop ?? 80;
    $desktopTop = $desktopTop ?? 132;
@endphp

<div
    class="pointer-events-none absolute left-0 block h-px w-full opacity-0 tab:hidden"
    style="top: {{ $mobileTop }}px"
    data-lum-sticky-trigger
    aria-hidden="true"
></div>
<div
    class="pointer-events-none absolute left-0 hidden h-px w-full opacity-0 tab:block desk:hidden"
    style="top: {{ $tabletTop }}px"
    data-lum-sticky-trigger
    aria-hidden="true"
></div>
<div
    class="pointer-events-none absolute left-0 hidden h-px w-full opacity-0 desk:block"
    style="top: {{ $desktopTop }}px"
    data-lum-sticky-trigger
    aria-hidden="true"
></div>
