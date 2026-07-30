@extends('layouts.lum')

@section('title', $excursion['meta_title'])

@section('content')
@php
    $img = fn (string $path) => asset('images/lum/' . $path);
@endphp

<div class="lum-viewport" data-lum-excursion-page>
    <div class="lum-page">
        @include('lum.partials.discover-excursion.intro', ['img' => $img, 'excursion' => $excursion])
        @include('lum.partials.discover-excursion.hero-oval', ['img' => $img, 'excursion' => $excursion])
        @include('lum.partials.discover-excursion.gallery', ['img' => $img, 'excursion' => $excursion])
        @include('lum.partials.discover-excursion.package', ['img' => $img, 'excursion' => $excursion])
        @include('lum.partials.impression', [
            'img' => $img,
            'variant' => 'villa',
            'titleKey' => 'lum.excursion.impression',
            'imgBase' => $excursion['impression']['img_base'] ?? 'discover/detail/shared/impression',
            'showCta' => true,
            'showLogomark' => false,
            'showTabs' => true,
            'ctaLabel' => $excursion['impression']['cta'] ?? __('lum.excursion.book'),
            'ctaHref' => $excursion['impression']['cta_href']
                ?? $excursion['book_url']
                ?? \App\Support\Site::bookUrl(),
            'cmsImpression' => $excursion['impression'] ?? null,
        ])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
