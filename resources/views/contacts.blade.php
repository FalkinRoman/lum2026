@extends('layouts.lum')

@section('title', __('lum.meta.contact_title'))

@section('content')
@php
    $img = fn (string $path) => \App\Support\Content::mediaUrl($path);
    $contact = $contact ?? \App\Support\Content::contact();
@endphp

<div class="lum-viewport" data-lum-contact-page>
    <div class="lum-page">
        @include('lum.partials.contact.main', ['img' => $img, 'contact' => $contact])
        @include('lum.partials.footer', ['img' => $img])
    </div>
</div>
@endsection
