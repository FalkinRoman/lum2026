@php
    $wrapperClass = $wrapperClass ?? 'text-lum-ivory';
    $creditsClass = $creditsClass ?? '';
@endphp

<p @class(['lum-footer-credits', $creditsClass, $wrapperClass])>
    <span>{{ __('lum.footer.credits_prefix') }}&nbsp;</span>
    @include('lum.partials.link-footer-nav', [
        'img' => $img,
        'href' => 'https://t.me/ivantaskayev',
        'label' => __('lum.footer.ivan'),
        'classes' => 'lum-link--footer-credits',
        'variant' => 'line',
        'target' => '_blank',
        'rel' => 'noopener noreferrer',
    ])
    <span>&nbsp;&amp;&nbsp;</span>
    @include('lum.partials.link-footer-nav', [
        'img' => $img,
        'href' => 'https://t.me/falroman',
        'label' => __('lum.footer.roman'),
        'classes' => 'lum-link--footer-credits',
        'variant' => 'line',
        'target' => '_blank',
        'rel' => 'noopener noreferrer',
    ])
</p>
