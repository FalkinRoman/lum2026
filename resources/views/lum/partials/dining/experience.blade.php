@php
    use App\Support\Content;
@endphp
@include('lum.partials.quote-choice', [
    'img' => $img,
    'heroImageUrl' => Content::pageMediaUrl('dining', 'media', 'hero_image', 'dining/wellness-hero.webp'),
    'ovalImageUrl' => Content::pageOptionalMediaUrl('dining', 'media', 'oval_image', 'dining/wellness-oval.webp'),
    'quoteLine1' => Content::pageText('dining', 'quote', 'quote_line1'),
    'quoteLine2' => Content::pageText('dining', 'quote', 'quote_line2'),
    'noteLine1' => Content::pageText('dining', 'quote', 'note_line1'),
    'noteLine2' => Content::pageText('dining', 'quote', 'note_line2'),
])
