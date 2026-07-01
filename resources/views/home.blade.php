@extends('layouts.lum')

@section('content')
@php
    $img = fn (string $path) => asset('images/lum/' . $path);
@endphp

<div class="lum-viewport">
    <div class="lum-page">
        @include('lum.partials.hero', ['img' => $img])
        @include('lum.partials.polaroids', ['img' => $img])
        @include('lum.partials.villas', ['img' => $img])
        @include('lum.partials.location', ['img' => $img])
        @include('lum.partials.impression', ['img' => $img])
        @include('lum.partials.blog', ['img' => $img])
        @include('lum.partials.shop', ['img' => $img])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
