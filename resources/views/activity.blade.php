@extends('layouts.lum')

@section('title', $activity['meta_title'])

@section('content')
@php
    $img = fn (string $path) => asset('images/lum/' . $path);
    $assetBase = 'relax/detail/' . $slug;
@endphp

<div class="lum-viewport" data-lum-activity-page>
    <div class="lum-page">
        @include('lum.partials.activity.hero', ['img' => $img, 'activity' => $activity, 'assetBase' => $assetBase])
        @include('lum.partials.activity.gallery', ['img' => $img, 'activity' => $activity, 'assetBase' => $assetBase])
        @include('lum.partials.activity.pricing', ['img' => $img, 'activity' => $activity])
        @include('lum.partials.impression', [
            'img' => $img,
            'variant' => 'villa',
            'titleKey' => 'lum.activity.impression',
            'imgBase' => 'dining/detail/shared/impression',
            'showCta' => true,
            'showLogomark' => false,
            'ctaLabel' => __('lum.activity.make_reservation'),
        ])
        @include('lum.partials.quote-choice', [
            'img' => $img,
            'heroImage' => 'dining/detail/shared/quote-hero.webp',
            'ovalImage' => 'dining/detail/shared/quote-oval.webp',
            'quoteLine1' => $activity['quote']['line1'],
            'quoteLine2' => $activity['quote']['line2'],
            'noteLine1' => $activity['quote']['note_line1'],
            'noteLine2' => $activity['quote']['note_line2'],
        ])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
