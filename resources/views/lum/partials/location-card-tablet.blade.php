<article @class(['relative h-[650px] w-[450px] border border-dashed border-lum-espresso bg-lum-sand', 'mt-[40px]' => ! empty($stacked)])>
    <div class="lum-location-card__bg">
        <img src="{{ $img('location/dining-bg.svg') }}" alt="" class="absolute left-1/2 top-1/2 size-[1048px] -translate-x-1/2 -translate-y-1/2 max-w-none" width="1048" height="1048">
    </div>
    @if ($card['activeImgRotate'])
        <div class="absolute left-1/2 top-1/2 flex -translate-x-1/2 -translate-y-1/2 items-center justify-center">
            <div class="-rotate-[15deg]">
                <img src="{{ $img($card['activeImg']) }}" alt="" class="{{ $layout['tabImg'] }} {{ $card['activeImgClass'] }}">
            </div>
        </div>
    @else
        <img src="{{ $img($card['activeImg']) }}" alt="" class="absolute left-1/2 top-1/2 {{ $layout['tabImg'] }} -translate-x-1/2 -translate-y-1/2 {{ $card['activeImgClass'] }}">
    @endif
    <h3 class="absolute left-1/2 top-[44px] -translate-x-1/2 font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">{{ $card['title'] }}</h3>
    @include('lum.partials.location-card-tag', ['top' => $card['tagTop']['tab'], 'tag' => $card['tag']])
    @include('lum.partials.location-card-list', ['top' => $card['listTop']['tab'], 'lines' => $card['listLines']])
    <a href="{{ ! empty($card['route']) ? route($card['route']) : '#' }}" class="lum-btn lum-btn-info absolute left-1/2 top-[574px] -translate-x-1/2 px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.location.more_info') }}</a>
</article>
