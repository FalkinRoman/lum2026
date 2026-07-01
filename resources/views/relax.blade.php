@extends('layouts.lum')

@section('title', __('lum.meta.relax_title'))

@section('content')
@php
    $img = fn (string $path) => asset('images/lum/' . $path);
@endphp

<div class="lum-viewport" data-lum-relax-page>
    <div class="lum-page">
        @include('lum.partials.relax.venues', ['img' => $img])
        @include('lum.partials.relax.quote', ['img' => $img])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
