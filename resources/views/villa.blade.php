@extends('layouts.lum')

@section('title', $villa['meta_title'])

@push('head')
    @include('lum.exely.head')
@endpush

@section('content')
@php
    $img = fn (string $path) => asset('images/lum/' . $path);
    $hotelId = \App\Support\Exely::hotelIdForVilla(
        $villa['slug'] ?? null,
        $villa['exely_hotel_id'] ?? null,
    );
@endphp

<div class="lum-viewport">
    <div class="lum-page">
        @include('lum.partials.villa.hero', ['img' => $img, 'villa' => $villa])

        @if (\App\Support\Exely::enabled())
            {{-- Поиск под torn-edge, ширина = сетка Stay/виллы --}}
            <section class="lum-container relative z-[15] bg-lum-ivory">
                <div class="lum-villa-booking">
                    @include('lum.exely.search', [
                        'variant' => 'inline',
                        'hotelId' => $hotelId,
                        'showHead' => false,
                    ])
                </div>
            </section>
        @endif

        @include('lum.partials.villa.gallery', ['img' => $img, 'villa' => $villa])
        @include('lum.partials.villa.facilities', ['img' => $img, 'villa' => $villa])
        @include('lum.partials.impression', [
            'img' => $img,
            'variant' => 'villa',
            'titleKey' => 'lum.villa.impression',
            'imgBase' => $villa['impression']['img_base'] ?? 'villa/impression',
            'showLogomark' => true,
            'showCta' => true,
            'ctaHref' => $villa['impression']['cta_href']
                ?? $villa['booking_url']
                ?? \App\Support\Site::takeABreakUrl(),
            'ctaLabel' => $villa['impression']['cta'] ?? null,
            'cmsImpression' => $villa['impression'] ?? null,
        ])
        @include('lum.partials.shop', ['img' => $img])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
