@extends('layouts.lum')

@section('title', $restaurant['meta_title'])

@section('content')
@php
    $img = fn (string $path) => asset('images/lum/' . $path);
    $assetBase = 'dining/detail/' . $slug;
@endphp

<div class="lum-viewport" data-lum-restaurant-page>
    <div class="lum-page">
        @include('lum.partials.restaurant.hero', ['img' => $img, 'restaurant' => $restaurant, 'assetBase' => $assetBase])
        @include('lum.partials.restaurant.gallery', ['img' => $img, 'restaurant' => $restaurant, 'assetBase' => $assetBase])
        @include('lum.partials.restaurant.menu', ['img' => $img, 'restaurant' => $restaurant])
        @include('lum.partials.impression', [
            'img' => $img,
            'variant' => 'villa',
            'titleKey' => 'lum.restaurant.impression',
            'imgBase' => 'dining/detail/shared/impression',
            'showCta' => true,
            'showLogomark' => false,
            'ctaLabel' => __('lum.restaurant.book_table'),
        ])
        @include('lum.partials.quote-choice', [
            'img' => $img,
            'heroImage' => 'dining/detail/shared/quote-hero.webp',
            'ovalImage' => 'dining/detail/shared/quote-oval.webp',
            'quoteLine1' => $restaurant['quote']['line1'],
            'quoteLine2' => $restaurant['quote']['line2'],
            'noteLine1' => $restaurant['quote']['note_line1'],
            'noteLine2' => $restaurant['quote']['note_line2'],
        ])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
