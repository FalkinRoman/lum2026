@extends('layouts.lum')

@section('title', $excursion['meta_title'])

@section('content')
@php
    $img = fn (string $path) => asset('images/lum/' . $path);
    $assetBase = 'discover/detail/' . $slug;
@endphp

<div class="lum-viewport" data-lum-excursion-page>
    <div class="lum-page">
        @include('lum.partials.discover-excursion.intro', ['img' => $img, 'excursion' => $excursion])
        @include('lum.partials.discover-excursion.hero-oval', ['img' => $img, 'assetBase' => $assetBase])
        @include('lum.partials.discover-excursion.gallery', ['img' => $img, 'excursion' => $excursion, 'assetBase' => $assetBase])
        @include('lum.partials.discover-excursion.package', ['img' => $img, 'excursion' => $excursion, 'assetBase' => $assetBase])
        @include('lum.partials.impression', [
            'img' => $img,
            'variant' => 'villa',
            'titleKey' => 'lum.excursion.impression',
            'imgBase' => 'discover/detail/shared/impression',
            'showCta' => false,
            'showLogomark' => false,
            'showTabs' => false,
            'ctaLabel' => __('lum.excursion.book'),
        ])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
