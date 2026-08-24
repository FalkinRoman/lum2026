@extends('layouts.lum')

@section('title', $activity['meta_title'])

@section('content')
@php
    $img = fn (string $path) => \App\Support\Content::mediaUrl($path);
@endphp

<div class="lum-viewport" data-lum-activity-page>
    <div class="lum-page">
        @include('lum.partials.activity.hero', ['img' => $img, 'activity' => $activity])
        @include('lum.partials.activity.gallery', ['img' => $img, 'activity' => $activity])
        @include('lum.partials.activity.pricing', ['img' => $img, 'activity' => $activity])
        @include('lum.partials.impression', [
            'img' => $img,
            'variant' => 'villa',
            'titleKey' => 'lum.activity.impression',
            'imgBase' => $activity['impression']['img_base'] ?? 'dining/detail/shared/impression',
            'showCta' => true,
            'showLogomark' => false,
            'ctaLabel' => $activity['impression']['cta'] ?? __('lum.activity.make_reservation'),
            'ctaHref' => $activity['impression']['cta_href']
                ?? $activity['pricing']['cta_url']
                ?? \App\Support\Site::bookUrl(),
            'cmsImpression' => $activity['impression'] ?? null,
        ])
        @include('lum.partials.quote-choice', [
            'img' => $img,
            'heroImage' => $activity['quote']['hero_image'] ?? 'dining/detail/shared/quote-hero.webp',
            'ovalImage' => $activity['quote']['oval_image'] ?? null,
            'quoteLine1' => $activity['quote']['line1'],
            'quoteLine2' => $activity['quote']['line2'],
            'noteLine1' => $activity['quote']['note_line1'],
            'noteLine2' => $activity['quote']['note_line2'],
        ])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
