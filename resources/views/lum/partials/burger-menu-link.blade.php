@php
    $href = $href ?? '#';
    $label = $label ?? '';
    $active = (bool) ($active ?? false);
    $class = $class ?? '';
@endphp
{{-- Hover: same CSS mask-slide as header `.lum-nav-link` / `.lum-text-slide` --}}
<a
    href="{{ $href }}"
    @class([
        'lum-menu-item lum-text-slide',
        'is-active' => $active,
        $class,
    ])
>
    <span class="lum-menu-link__clip">
        <span class="lum-menu-link__enter" data-lum-menu-link-text>
            <span class="lum-text-slide__mask">
                <span class="lum-text-slide__track">
                    <span class="lum-text-slide__line">{{ $label }}</span>
                    <span class="lum-text-slide__line" aria-hidden="true">{{ $label }}</span>
                </span>
            </span>
            @if ($active)
                <span class="lum-menu-dot" data-lum-menu-dot aria-hidden="true"></span>
            @endif
        </span>
    </span>
</a>
