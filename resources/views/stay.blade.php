@extends('layouts.lum')

@section('title', __('lum.meta.stay_title'))

@section('content')
@php
    $img = fn (string $path) => asset('images/lum/' . $path);
@endphp

<div class="lum-viewport">
    <div class="lum-page">
        @include('lum.partials.stay.properties', ['img' => $img])
        @include('lum.partials.stay.wellness', ['img' => $img])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
