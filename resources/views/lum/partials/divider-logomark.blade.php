{{-- Line + Lum logomark divider (espresso @ 16% via interior/logomark.svg) --}}
@php
    $size = $size ?? 'desk'; // mob|tab|desk
    $dims = match ($size) {
        'mob' => ['mark' => 32, 'gap' => 16, 'w' => 'w-[335px]', 'h' => 'h-[32px]'],
        'tab' => ['mark' => 40, 'gap' => 18, 'w' => 'w-[920px]', 'h' => 'h-[40px]'],
        default => ['mark' => 64, 'gap' => 22, 'w' => 'w-[1776px]', 'h' => 'h-[64px]'],
    };
    $extraClass = $class ?? '';
@endphp
<div @class([
    'flex items-center',
    $dims['w'],
    $dims['h'],
    $extraClass,
]) style="gap: {{ $dims['gap'] }}px" {!! $attrs ?? '' !!}>
    <div class="h-px flex-1 bg-lum-espresso/40"></div>
    <img
        src="{{ $img('interior/logomark.svg') }}"
        alt=""
        class="shrink-0"
        style="width: {{ $dims['mark'] }}px; height: {{ $dims['mark'] }}px"
        width="{{ $dims['mark'] }}"
        height="{{ $dims['mark'] }}"
    >
    <div class="h-px flex-1 bg-lum-espresso/40"></div>
</div>
