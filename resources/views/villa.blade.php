@extends('layouts.lum')

@section('title', $villa['meta_title'])

@section('content')
@php
    $img = fn (string $path) => asset('images/lum/' . $path);
@endphp

<div class="lum-viewport">
    <div class="lum-page">
        @include('lum.partials.villa.hero', ['img' => $img, 'villa' => $villa])
        @include('lum.partials.villa.gallery', ['img' => $img, 'villa' => $villa])
        @include('lum.partials.villa.facilities', ['img' => $img])
        @include('lum.partials.impression', [
            'img' => $img,
            'variant' => 'villa',
            'titleKey' => 'lum.villa.impression',
            'imgBase' => 'villa/impression',
            'showLogomark' => true,
            'showCta' => true,
            'ctaClass' => 'lum-btn lum-btn-info',
        ])
        @include('lum.partials.shop', ['img' => $img])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
