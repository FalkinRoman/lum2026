@extends('layouts.lum')

@section('title', ($page['title'] ?: __('lum.footer.privacy')).' — Lum')

@section('content')
@php
    $img = fn (string $path) => \App\Support\Content::mediaUrl($path);
@endphp

<div class="lum-viewport" data-lum-legal-page>
    <div class="lum-page">
        @include('lum.partials.legal.page', ['img' => $img, 'page' => $page])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
