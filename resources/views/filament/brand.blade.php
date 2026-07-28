@props([
    'dark' => false,
])

@php
    $logo = $dark
        ? asset('images/lum/menu/logo-lum-white.svg')
        : asset('images/lum/menu/logo-lum-espresso.svg');
@endphp

<div class="lum-admin-brand">
    <img
        src="{{ $logo }}"
        alt="LUM"
        class="lum-admin-brand__logo"
        width="104"
        height="40"
    >
</div>
