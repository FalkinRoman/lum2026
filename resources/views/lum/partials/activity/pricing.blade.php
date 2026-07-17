@php
    $pricing = $activity['pricing'];
    $items = $pricing['items'];
    $listItems = array_slice($items, 0, 3);
    $deskItems = $items;
@endphp

<section class="lum-container relative bg-lum-ivory" data-lum-scroll-reveal>
    {{-- MOBILE — Figma 190:773 (3 items) --}}
    <div class="relative h-[917px] tab:hidden">
        <p class="lum-script absolute left-1/2 top-[44px] -translate-x-1/2 whitespace-nowrap text-center text-[24px] leading-none tracking-[1.2px] text-[#752a23]">{{ $pricing['eyebrow'] }}</p>
        <h2 class="absolute left-1/2 top-[104px] w-[201px] -translate-x-1/2 text-center font-serif text-[42px] leading-[45px] text-lum-espresso">
            {{ $pricing['title_normal'] }}<span class="font-medium italic">{{ $pricing['title_italic'] }}</span>
        </h2>

        <div class="absolute left-[20px] top-[250px] flex w-[335px] flex-col">
            @foreach ($listItems as $item)
                <div class="flex flex-col items-center border-t border-lum-espresso/16 pt-[21px] pb-[44px] text-center last:pb-0">
                    <p class="font-serif text-[16px] font-medium leading-[20px] tracking-[-0.32px] text-[#752a23]">{{ $item['title'] }}</p>
                    <p class="mt-[14px] max-w-[257px] text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso">{{ $item['description'] }}</p>
                    <div class="mt-[16px] flex items-center gap-[20px]">
                        <p class="text-[14px] font-medium uppercase leading-[14px] tracking-[0.6px] text-lum-espresso">{{ $item['price'] }}</p>
                        <div class="flex items-center gap-[6px]">
                            <img src="{{ $img('relax/detail/shared/clock.svg') }}" alt="" class="size-[20px]" width="20" height="20">
                            <p class="text-[14px] leading-[22px] tracking-[0.1px] text-lum-espresso/40">{{ $item['duration'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <a href="#" class="lum-btn lum-btn-info absolute left-1/2 top-[805px] -translate-x-1/2 whitespace-nowrap px-[34px] pt-[6px] pb-[5px] text-[16px] font-extrabold leading-[25px] tracking-[3.2px]">{{ $pricing['cta'] }}</a>
    </div>

    {{-- TABLET — Figma 190:624 (3 items) --}}
    <div class="relative hidden h-[995px] tab:block desk:hidden">
        <p class="lum-script absolute left-1/2 top-[80px] -translate-x-1/2 whitespace-nowrap text-center text-[28px] leading-none tracking-[1.4px] text-[#752a23]">{{ $pricing['eyebrow'] }}</p>
        <h2 class="absolute left-1/2 top-[152px] -translate-x-1/2 whitespace-nowrap text-center font-serif text-[52px] leading-[52px] text-lum-espresso">
            {{ $pricing['title_normal'] }}<span class="font-medium italic">{{ $pricing['title_italic'] }}</span>
        </h2>

        <div class="absolute left-[51px] top-[276px] flex w-[856px] flex-col">
            @foreach ($listItems as $item)
                <div class="flex flex-col items-center border-t border-lum-espresso/16 pt-[21px] pb-[64px] text-center last:pb-0">
                    <p class="font-serif text-[20px] font-medium leading-[24px] tracking-[-0.4px] text-[#752a23]">{{ $item['title'] }}</p>
                    <p class="mt-[16px] max-w-[471px] text-[18px] leading-[26px] tracking-[0.1px] text-lum-espresso">{{ $item['description'] }}</p>
                    <div class="mt-[12px] flex items-center gap-[20px]">
                        <p class="text-[18px] font-medium uppercase leading-[18px] tracking-[1.8px] text-lum-espresso">{{ $item['price'] }}</p>
                        <div class="flex items-center gap-[6px]">
                            <img src="{{ $img('relax/detail/shared/clock.svg') }}" alt="" class="size-[24px]" width="24" height="24">
                            <p class="text-[18px] leading-[26px] tracking-[0.1px] text-lum-espresso/40">{{ $item['duration'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <a href="#" class="lum-btn lum-btn-info absolute left-1/2 top-[883px] -translate-x-1/2 whitespace-nowrap px-[34px] pt-[6px] pb-[5px] text-[16px] font-extrabold leading-[25px] tracking-[3.2px]">{{ $pricing['cta'] }}</a>
    </div>

    {{-- DESKTOP — Figma 190:461 (2×2) --}}
    <div class="relative hidden h-[916px] desk:block">
        <p class="lum-script absolute left-1/2 top-[120px] -translate-x-1/2 whitespace-nowrap text-center text-[28px] leading-none tracking-[1.4px] text-[#752a23]">{{ $pricing['eyebrow'] }}</p>
        <h2 class="absolute left-1/2 top-[192px] w-[856px] -translate-x-1/2 text-center font-serif text-[88px] leading-[94px] text-lum-espresso">
            {{ $pricing['title_normal'] }}<span class="font-medium italic">{{ $pricing['title_italic'] }}</span>
        </h2>

        <div class="absolute left-[72px] top-[366px] grid w-[1776px] grid-cols-2 gap-x-[64px]">
            @foreach ($deskItems as $item)
                <div class="flex flex-col items-center border-t border-lum-espresso/16 pt-[21px] pb-[63px] text-center">
                    <p class="font-serif text-[20px] font-medium leading-[24px] tracking-[-0.4px] text-[#752a23]">{{ $item['title'] }}</p>
                    <p class="mt-[16px] max-w-[471px] text-[18px] leading-[26px] tracking-[0.1px] text-lum-espresso">{{ $item['description'] }}</p>
                    <div class="mt-[12px] flex items-center gap-[20px]">
                        <p class="text-[18px] font-medium uppercase leading-[18px] tracking-[1.8px] text-lum-espresso">{{ $item['price'] }}</p>
                        <div class="flex items-center gap-[6px]">
                            <img src="{{ $img('relax/detail/shared/clock.svg') }}" alt="" class="size-[24px]" width="24" height="24">
                            <p class="text-[18px] leading-[26px] tracking-[0.1px] text-lum-espresso/40">{{ $item['duration'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <a href="#" class="lum-btn lum-btn-info absolute left-1/2 top-[760px] -translate-x-1/2 whitespace-nowrap px-[34px] pt-[6px] pb-[5px] text-[16px] font-extrabold leading-[25px] tracking-[3.2px]">{{ $pricing['cta'] }}</a>
    </div>
</section>
