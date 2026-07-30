@extends('layouts.lum')

@section('title', $restaurant['meta_title'])

@section('content')
@php
    $img = fn (string $path) => asset('images/lum/' . $path);
@endphp

<div class="lum-viewport" data-lum-restaurant-page>
    <div class="lum-page">
        @include('lum.partials.restaurant.hero', ['img' => $img, 'restaurant' => $restaurant])
        @include('lum.partials.restaurant.gallery', ['img' => $img, 'restaurant' => $restaurant])
        @include('lum.partials.restaurant.menu', [
            'img' => $img,
            'restaurant' => $restaurant,
            'menuCategories' => $menuCategories,
        ])
        @include('lum.partials.impression', [
            'img' => $img,
            'variant' => 'villa',
            'titleKey' => 'lum.restaurant.impression',
            'imgBase' => $restaurant['impression']['img_base'] ?? 'dining/detail/shared/impression',
            'showCta' => true,
            'showLogomark' => false,
            'ctaLabel' => $restaurant['impression']['cta'] ?? __('lum.restaurant.book_table'),
            'ctaHref' => $restaurant['impression']['cta_href']
                ?? $restaurant['book_url']
                ?? \App\Support\Site::bookUrl(),
            'cmsImpression' => $restaurant['impression'] ?? null,
        ])
        @include('lum.partials.quote-choice', [
            'img' => $img,
            'heroImage' => $restaurant['quote']['hero_image'] ?? 'dining/detail/shared/quote-hero.webp',
            'ovalImage' => $restaurant['quote']['oval_image'] ?? 'dining/detail/shared/quote-oval.webp',
            'quoteLine1' => $restaurant['quote']['line1'],
            'quoteLine2' => $restaurant['quote']['line2'],
            'noteLine1' => $restaurant['quote']['note_line1'],
            'noteLine2' => $restaurant['quote']['note_line2'],
        ])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
