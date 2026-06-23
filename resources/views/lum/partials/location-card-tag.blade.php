<div class="lum-location-card__tag-wrap absolute left-1/2 -translate-x-1/2" style="top: {{ $top }}px; width: max-content; max-width: none;" @if(!empty($reveal)) data-lum-reveal="{{ $reveal }}" @endif>
    <div class="lum-location-card__tag-rotate rotate-[1deg]" style="width: max-content; max-width: none;">
        <div @class(['lum-location-card__tag bg-lum-cream', $padding ?? 'px-[48px] py-[4px]']) style="white-space: nowrap; width: max-content; max-width: none;">
            <span class="lum-location-card__tag-text font-serif text-lum-espresso" style="white-space: nowrap;">{!! $tag !!}</span>
        </div>
    </div>
</div>
