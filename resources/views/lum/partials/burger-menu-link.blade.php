@php
    $href = $href ?? '#';
    $label = $label ?? '';
    $active = (bool) ($active ?? false);
    $class = $class ?? '';
@endphp
<a
    href="{{ $href }}"
    @class([
        'lum-menu-item',
        'is-active' => $active,
        $class,
    ])
>
    {{ $label }}
    @if ($active)
        <span class="lum-menu-dot" data-lum-menu-dot aria-hidden="true"></span>
    @endif
</a>
