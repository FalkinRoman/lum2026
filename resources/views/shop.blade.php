@extends('layouts.lum')

@section('title', __('lum.meta.shop_title'))

@section('content')
@php
    $img = fn (string $path) => asset('images/lum/' . $path);
@endphp

<div class="lum-viewport" data-lum-shop-page>
    <div class="lum-page">
        @include('lum.partials.shop-page.catalog', ['img' => $img])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
