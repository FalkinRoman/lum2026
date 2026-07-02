@extends('layouts.lum')

@section('title', __('lum.meta.blog_title'))

@section('content')
@php
    $img = fn (string $path) => asset('images/lum/' . $path);
@endphp

<div class="lum-viewport" data-lum-blog-page>
    <div class="lum-page">
        @include('lum.partials.blog-page.listing', ['img' => $img])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
