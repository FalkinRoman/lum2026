@extends('layouts.lum')

@section('title', __('lum.meta.booking_title'))

@push('head')
    @include('lum.exely.head')
    <style>
        /*
         * overflow-x только на html. На body overflow-x:hidden форсит overflow-y:auto
         * → два скролл-контейнера (html+body) и дёрганый/мёртвый скролл.
         * НЕ .lum-page — та же ловушка overflow-x≠visible → overflow-y:auto.
         */
        html { overflow-x: hidden; overflow-y: scroll; }
        body { overflow: visible; }
    </style>
@endpush

@section('content')
@php
    $img = fn (string $path) => \App\Support\Content::mediaUrl($path);
@endphp

<div class="lum-viewport">
    <div class="lum-page" data-lum-no-scale>
        <section class="lum-container relative bg-lum-ivory" data-lum-booking-page>
            <div class="tab:hidden">
                @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
            </div>
            <div class="hidden tab:block desk:hidden">
                @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])
            </div>
            <div class="hidden desk:block">
                @include('lum.partials.header', ['headerTone' => 'espresso', 'headerActive' => 'stay'])
            </div>
            @include('lum.partials.sticky-trigger')

            <div class="lum-booking-page__intro flex flex-col items-center gap-[16px] tab:gap-[20px] desk:gap-[24px]">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px] tab:size-[8px] desk:size-[12px]" width="12" height="12">
                <p class="lum-text-3 tab:lum-text-2 desk:lum-eyebrow font-medium uppercase text-lum-espresso/40">
                    {{ __('lum.booking.eyebrow') }}
                </p>
                <h1 class="font-serif text-[42px] leading-[45px] text-lum-espresso tab:text-[52px] tab:leading-[52px] desk:text-[72px] desk:leading-[76px]">
                    {{ __('lum.booking.title') }}
                </h1>
            </div>

            <div class="lum-booking-page__engine">
                @include('lum.exely.booking')
            </div>
        </section>

        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
