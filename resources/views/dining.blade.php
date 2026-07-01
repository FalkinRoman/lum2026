@extends('layouts.lum')

@section('title', __('lum.meta.dining_title'))

@section('content')
@php
    $img = fn (string $path) => asset('images/lum/' . $path);
@endphp

<div class="lum-viewport">
    <div class="lum-page">
        @include('lum.partials.dining.venues', ['img' => $img])
        @include('lum.partials.dining.experience', ['img' => $img])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
