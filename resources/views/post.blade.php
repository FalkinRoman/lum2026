@extends('layouts.lum')

@section('title', $post['meta_title'])

@section('meta')
@php
    $metaDescription = $post['meta_description'] ?? '';
    $ogImage = ! empty($post['hero'])
        ? asset('images/lum/blog/'.$post['hero'])
        : (! empty($post['image']) ? asset('images/lum/blog/'.$post['image']) : null);
    $canonical = route('blog.show', ['slug' => $post['slug'] ?? $slug]);
@endphp
    @if ($metaDescription !== '')
        <meta name="description" content="{{ $metaDescription }}">
        <meta property="og:description" content="{{ $metaDescription }}">
    @endif
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $post['meta_title'] }}">
    <meta property="og:url" content="{{ $canonical }}">
    @if ($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
    @endif
    <link rel="canonical" href="{{ $canonical }}">
@endsection

@section('content')
@php
    $img = fn (string $path) => asset('images/lum/' . $path);
    $backHref = request('from') === 'home' ? route('home') : route('blog');
@endphp

<div class="lum-viewport" data-lum-blog-page>
    <div class="lum-page">
        @include('lum.partials.blog-page.detail', ['img' => $img, 'post' => $post, 'slug' => $slug, 'backHref' => $backHref])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
