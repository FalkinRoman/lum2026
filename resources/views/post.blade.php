@extends('layouts.lum')

@section('title', $post['meta_title'])

@section('content')
@php
    $img = fn (string $path) => asset('images/lum/' . $path);
@endphp

<div class="lum-viewport" data-lum-blog-page>
    <div class="lum-page">
        @include('lum.partials.blog-page.detail', ['img' => $img, 'post' => $post, 'slug' => $slug])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
