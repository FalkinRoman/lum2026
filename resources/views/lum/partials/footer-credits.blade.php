@php
    $wrapperClass = $wrapperClass ?? 'text-lum-ivory';
    $creditsClass = $creditsClass ?? '';
@endphp

<p @class(['lum-footer-credits', $creditsClass, $wrapperClass])>
    <span>Des &amp; Dev /&nbsp;</span>
    @include('lum.partials.link-footer-nav', [
        'img' => $img,
        'href' => 'https://t.me/ivantaskayev',
        'label' => 'Ivan Taskayev',
        'classes' => 'lum-link--footer-credits',
        'target' => '_blank',
        'rel' => 'noopener noreferrer',
    ])
    <span>&nbsp;&amp;&nbsp;</span>
    @include('lum.partials.link-footer-nav', [
        'img' => $img,
        'href' => 'https://t.me/falroman',
        'label' => 'Roman Falkin',
        'classes' => 'lum-link--footer-credits',
        'target' => '_blank',
        'rel' => 'noopener noreferrer',
    ])
</p>
