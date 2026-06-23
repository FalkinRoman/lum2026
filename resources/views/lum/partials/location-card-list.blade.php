<div @class(['lum-location-card__list absolute left-1/2 -translate-x-1/2 text-center text-lum-espresso', $class ?? 'lum-text-2']) style="top: {{ $top }}px">
    @foreach ($lines as $line)
        <span class="block whitespace-nowrap">{{ $line }}</span>
    @endforeach
</div>
