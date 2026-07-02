<section class="lum-container relative bg-lum-ivory">
    {{-- MOBILE — Figma 108:715 --}}
    <div class="relative h-[1466px] tab:hidden">
        @include('lum.partials.header-mobile', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger')

        <div class="absolute inset-0" data-lum-villa-intro>
            <div class="absolute left-1/2 top-[124px] flex w-[335px] -translate-x-1/2 flex-col items-center gap-[16px]" data-lum-stay-intro-item data-lum-stay-intro-order="1">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                <h1 class="text-center font-serif text-[42px] leading-[45px] text-lum-espresso">{{ $contact['title'] }}</h1>
            </div>

            <div class="absolute left-1/2 top-[249px] -translate-x-1/2 -translate-y-1/2">
                <p class="text-center text-[20px] font-medium uppercase leading-[26px] tracking-[3.2px] text-lum-espresso/40" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                    {!! str_replace(', ', ',<br>', e($contact['address'])) !!}
                </p>
            </div>
        </div>

        <div class="absolute left-1/2 top-[319px] h-[387px] w-[335px] -translate-x-1/2 overflow-hidden">
            <div class="h-full w-full" data-lum-villa-card>
                <img src="{{ $img('contact/map-mob.webp') }}" alt="" class="h-full w-full object-cover" width="335" height="387" loading="lazy">
            </div>
        </div>

        <a href="#" class="lum-btn-espresso absolute left-[109px] top-[642px] px-[24px] py-[5px] text-[14px] font-extrabold uppercase leading-[23px] tracking-[2.84px] whitespace-nowrap" data-lum-scroll-reveal>{{ strtoupper($contact['see_on_map']) }}</a>

        <div class="absolute left-1/2 top-[750px] flex w-[100px] -translate-x-1/2 flex-col gap-[16px] text-center" data-lum-scroll-reveal>
            @foreach ($contact['hours'] as $index => $slot)
                @if ($index > 0)
                    <div class="h-px w-full bg-lum-espresso/16"></div>
                @endif
                <div>
                    <p class="text-[14px] font-medium leading-[14px] tracking-[0.6px] text-lum-espresso/40">{{ $slot['label'] }}</p>
                    <p class="text-[14px] font-medium leading-[14px] tracking-[0.6px] text-lum-espresso">{{ $slot['value'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="absolute left-1/2 top-[895px] h-px w-[335px] -translate-x-1/2 bg-lum-espresso/16"></div>

        <a href="tel:+94779296087" class="absolute left-[calc(50%+162.5px)] top-[962.5px] -translate-x-full -translate-y-1/2 whitespace-nowrap text-right font-serif text-[42px] leading-[45px] text-lum-espresso" data-lum-scroll-reveal>{{ $contact['phone'] }}</a>
        <a href="mailto:{{ $contact['email'] }}" class="absolute left-[calc(50%+102.5px)] top-[1016px] -translate-x-full -translate-y-1/2 whitespace-nowrap text-right font-serif text-[22px] font-medium leading-[24px] tracking-[0.19px] text-lum-espresso" data-lum-scroll-reveal>{{ $contact['email'] }}</a>

        <div class="absolute left-1/2 top-[1067px] h-px w-[335px] -translate-x-1/2 bg-lum-espresso/16"></div>

        <div class="absolute left-1/2 top-[1112px] w-[335px] -translate-x-1/2 space-y-[24px] text-center" data-lum-scroll-reveal>
            @foreach (array_slice($contact['legal'], 0, 2) as $row)
                <div>
                    <p class="text-[14px] font-medium leading-[14px] tracking-[0.6px] text-lum-espresso/40">{{ $row['label'] }}</p>
                    <p class="text-[14px] leading-[14px] text-lum-espresso">{{ $row['value'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="absolute left-1/2 top-[1236px] h-px w-[260px] -translate-x-1/2 bg-lum-espresso/16"></div>

        <div class="absolute left-1/2 top-[1269px] w-[335px] -translate-x-1/2 space-y-[24px] text-center" data-lum-scroll-reveal>
            @foreach (array_slice($contact['legal'], 2, 2) as $row)
                <div>
                    <p class="text-[14px] font-medium leading-[14px] tracking-[0.6px] text-lum-espresso/40">{{ $row['label'] }}</p>
                    <p class="text-[14px] leading-[14px] text-lum-espresso">{{ $row['value'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="absolute left-1/2 top-[1405px] h-px w-[335px] -translate-x-1/2 bg-lum-espresso/16"></div>
    </div>

    <div class="relative h-[660px] overflow-hidden tab:hidden">
        <img src="{{ $img('contact/hero.webp') }}" alt="" class="h-full w-full object-cover" width="375" height="660" loading="eager" data-lum-scroll-reveal data-lum-scroll-start="top 110%">
    </div>

    {{-- TABLET — Figma 108:536 --}}
    <div class="relative hidden h-[1310px] tab:block desk:hidden">
        @include('lum.partials.header-tablet', ['headerTone' => 'espresso'])

        <div class="absolute left-1/2 top-[120px] h-[508px] w-px -translate-x-1/2 bg-lum-espresso/16"></div>

        <div class="absolute inset-0" data-lum-villa-intro>
            <div class="absolute left-[calc(50%-240px)] top-[160px] flex -translate-x-1/2 flex-col items-center gap-[12px]" data-lum-stay-intro-item data-lum-stay-intro-order="1">
                <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[8px]" width="8" height="8">
                <h1 class="whitespace-nowrap text-center font-serif text-[52px] leading-[52px] text-lum-espresso">{{ $contact['title'] }}</h1>
            </div>

            <p class="absolute left-[calc(50%-240px)] top-[330px] -translate-x-1/2 -translate-y-1/2 text-center text-[24px] font-medium uppercase leading-[34px] tracking-[3.2px] text-lum-espresso/40" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                {!! str_replace(', ', ',<br>', e($contact['address'])) !!}
            </p>
        </div>

        <div class="absolute left-[186px] top-[444px] w-[100px] text-center" data-lum-scroll-reveal>
            <p class="lum-text-2 font-medium uppercase text-lum-espresso/40">{{ $contact['hours'][0]['label'] }}</p>
            <p class="lum-text-2 font-medium uppercase text-lum-espresso">{{ $contact['hours'][0]['value'] }}</p>
        </div>

        <div class="absolute left-[186px] top-[519px] h-px w-[100px] bg-lum-espresso/16"></div>

        <div class="absolute left-[186px] top-[538px] w-[100px] text-center" data-lum-scroll-reveal>
            <p class="lum-text-2 font-medium uppercase text-lum-espresso/40">{{ $contact['hours'][1]['label'] }}</p>
            <p class="lum-text-2 font-medium uppercase text-lum-espresso">{{ $contact['hours'][1]['value'] }}</p>
        </div>

        <div class="absolute left-[500px] top-[120px] h-[508px] w-[440px] overflow-hidden" data-lum-villa-card>
            <img src="{{ $img('contact/map-desk.webp') }}" alt="" class="h-full w-full object-cover" width="440" height="508" loading="lazy">
        </div>

        <a href="#" class="lum-btn-espresso absolute left-[638px] top-[564px] px-[24px] py-[5px] text-[14px] font-extrabold uppercase leading-[23px] tracking-[2.84px] whitespace-nowrap" data-lum-scroll-reveal>{{ strtoupper($contact['see_on_map']) }}</a>

        <div class="absolute left-1/2 top-[668px] h-px w-[920px] -translate-x-1/2 bg-lum-espresso/16"></div>

        <a href="tel:+94779296087" class="absolute left-[calc(50%+202px)] top-[755px] -translate-x-full -translate-y-1/2 whitespace-nowrap text-right font-serif text-[52px] leading-[52px] text-lum-espresso" data-lum-scroll-reveal>{{ $contact['phone'] }}</a>
        <a href="mailto:{{ $contact['email'] }}" class="absolute left-[calc(50%+144px)] top-[822px] -translate-x-full -translate-y-1/2 whitespace-nowrap text-right font-serif text-[28px] font-medium leading-[34px] tracking-[0.36px] text-lum-espresso" data-lum-scroll-reveal>{{ $contact['email'] }}</a>

        <div class="absolute left-1/2 top-[904px] flex -translate-x-1/2 gap-[10px]" data-lum-scroll-reveal>
            @include('lum.partials.footer-social', ['img' => $img, 'network' => 'instagram', 'tone' => 'light'])
            @include('lum.partials.footer-social', ['img' => $img, 'network' => 'whatsapp', 'tone' => 'light'])
        </div>

        <div class="absolute left-1/2 top-[996px] h-px w-[920px] -translate-x-1/2 bg-lum-espresso/16"></div>

        <div class="absolute left-[20px] top-[1057px] w-[450px] text-center" data-lum-scroll-reveal>
            <p class="lum-text-2 font-medium uppercase text-lum-espresso/40">{{ $contact['legal'][0]['label'] }}</p>
            <p class="lum-text-2 text-lum-espresso">{{ $contact['legal'][0]['value'] }}</p>
        </div>

        <div class="absolute left-[490px] top-[1057px] w-[450px] text-center" data-lum-scroll-reveal>
            <p class="lum-text-2 font-medium uppercase text-lum-espresso/40">{{ $contact['legal'][1]['label'] }}</p>
            <p class="lum-text-2 text-lum-espresso">{{ $contact['legal'][1]['value'] }}</p>
        </div>

        <div class="absolute left-[20px] top-[1139px] w-[450px] text-center" data-lum-scroll-reveal>
            <p class="lum-text-2 font-medium uppercase text-lum-espresso/40">{{ $contact['legal'][2]['label'] }}</p>
            <p class="lum-text-2 text-lum-espresso">{{ $contact['legal'][2]['value'] }}</p>
        </div>

        <div class="absolute left-[490px] top-[1139px] w-[450px] text-center" data-lum-scroll-reveal>
            <p class="lum-text-2 font-medium uppercase text-lum-espresso/40">{{ $contact['legal'][3]['label'] }}</p>
            <p class="lum-text-2 text-lum-espresso">{{ $contact['legal'][3]['value'] }}</p>
        </div>

        <div class="absolute left-1/2 top-[1249px] h-px w-[920px] -translate-x-1/2 bg-lum-espresso/16"></div>
    </div>

    <div class="relative hidden h-[660px] overflow-hidden tab:block desk:hidden">
        <img src="{{ $img('contact/hero.webp') }}" alt="" class="h-full w-full object-cover" width="960" height="660" loading="eager" data-lum-scroll-reveal data-lum-scroll-start="top 110%">
    </div>

    {{-- DESKTOP — Figma 108:400 --}}
    <div class="relative hidden desk:block" data-lum-villa-intro>
        <div class="relative h-[1069px]">
        @include('lum.partials.header', ['headerTone' => 'espresso'])
        @include('lum.partials.sticky-trigger', ['desktopTop' => 132])

        <div class="absolute left-[105px] top-[204px] flex flex-col items-center gap-[24px]" data-lum-stay-intro-item data-lum-stay-intro-order="1">
            <img src="{{ $img('stay/intro-dot.svg') }}" alt="" class="size-[12px]" width="12" height="12">
            <h1 class="whitespace-nowrap text-center font-serif text-[88px] leading-[94px] text-lum-espresso">{{ $contact['title'] }}</h1>
        </div>

        <div class="absolute left-[266px] top-[457px] -translate-x-1/2">
            <p class="text-center text-[24px] font-medium uppercase leading-[34px] tracking-[3.2px] text-lum-espresso/40" data-lum-stay-intro-item data-lum-stay-intro-order="2">
                {!! str_replace(', ', ',<br>', e($contact['address'])) !!}
            </p>
        </div>

        <div class="absolute left-[216px] top-[752px] w-[100px] text-center" data-lum-stay-intro-item data-lum-stay-intro-order="3">
            <p class="lum-text-2 font-medium uppercase text-lum-espresso/40">{{ $contact['hours'][0]['label'] }}</p>
            <p class="lum-text-2 font-medium uppercase text-lum-espresso">{{ $contact['hours'][0]['value'] }}</p>
        </div>

        <div class="absolute left-[266px] top-[827px] -translate-x-1/2">
            <div class="h-px w-[100px] bg-lum-espresso/16" data-lum-stay-intro-item data-lum-stay-intro-order="4"></div>
        </div>

        <div class="absolute left-[216px] top-[846px] w-[100px] text-center" data-lum-stay-intro-item data-lum-stay-intro-order="5">
            <p class="lum-text-2 font-medium uppercase text-lum-espresso/40">{{ $contact['hours'][1]['label'] }}</p>
            <p class="lum-text-2 font-medium uppercase text-lum-espresso">{{ $contact['hours'][1]['value'] }}</p>
        </div>

        <div class="absolute left-[532px] top-[204px] h-[684px] w-px bg-lum-espresso/16" data-lum-stay-intro-item data-lum-stay-intro-order="6"></div>

        <div class="absolute left-[605px] top-[204px] w-[323px] text-center" data-lum-stay-intro-item data-lum-stay-intro-order="7">
            <p class="lum-text-2 font-medium uppercase text-lum-espresso/40">{{ $contact['legal'][0]['label'] }}</p>
            <p class="lum-text-2 text-lum-espresso">{{ $contact['legal'][0]['value'] }}</p>
        </div>

        <div class="absolute left-[605px] top-[298px] w-[323px] text-center" data-lum-stay-intro-item data-lum-stay-intro-order="8">
            <p class="lum-text-2 font-medium uppercase text-lum-espresso/40">{{ $contact['legal'][1]['label'] }}</p>
            <p class="lum-text-2 text-lum-espresso">{{ $contact['legal'][1]['value'] }}</p>
        </div>

        <div class="absolute left-[1013px] top-[204px] w-[323px] text-center" data-lum-stay-intro-item data-lum-stay-intro-order="9">
            <p class="lum-text-2 font-medium uppercase text-lum-espresso/40">{{ $contact['legal'][2]['label'] }}</p>
            <p class="lum-text-2 text-lum-espresso">{{ $contact['legal'][2]['value'] }}</p>
        </div>

        <div class="absolute left-[1013px] top-[298px] w-[323px] text-center" data-lum-stay-intro-item data-lum-stay-intro-order="10">
            <p class="lum-text-2 font-medium uppercase text-lum-espresso/40">{{ $contact['legal'][3]['label'] }}</p>
            <p class="lum-text-2 text-lum-espresso">{{ $contact['legal'][3]['value'] }}</p>
        </div>

        <div class="absolute left-[605px] top-[392px] h-px w-[783px] bg-lum-espresso/16" data-lum-stay-intro-item data-lum-stay-intro-order="11"></div>

        <div class="absolute left-[1337px] top-[484px] -translate-x-full -translate-y-1/2">
            <a href="tel:+94779296087" class="block whitespace-nowrap text-right font-serif text-[88px] leading-[94px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="12">{{ $contact['phone'] }}</a>
        </div>

        <div class="absolute left-[1160px] top-[574px] -translate-x-full -translate-y-1/2">
            <a href="mailto:{{ $contact['email'] }}" class="block whitespace-nowrap text-right font-serif text-[32px] font-medium leading-[36px] tracking-[0.32px] text-lum-espresso" data-lum-stay-intro-item data-lum-stay-intro-order="13">{{ $contact['email'] }}</a>
        </div>

        <div class="absolute left-[956px] top-[852px] flex gap-[10px]" data-lum-stay-intro-item data-lum-stay-intro-order="14">
            @include('lum.partials.footer-social', ['img' => $img, 'network' => 'instagram', 'tone' => 'light'])
            @include('lum.partials.footer-social', ['img' => $img, 'network' => 'whatsapp', 'tone' => 'light'])
        </div>

        <div class="absolute left-[1452px] top-[168px] h-[756px] w-[396px] overflow-hidden" data-lum-stay-intro-item data-lum-stay-intro-order="15">
            <img src="{{ $img('contact/map-desk.webp') }}" alt="" class="h-full w-full object-cover" width="396" height="756" loading="eager">
        </div>

        <a href="#" class="lum-btn-espresso absolute left-[1550px] top-[844px] px-[34px] pt-[6px] pb-[5px] text-[16px] font-extrabold uppercase leading-[25px] tracking-[3.2px] whitespace-nowrap" data-lum-stay-intro-item data-lum-stay-intro-order="16">{{ strtoupper($contact['see_on_map']) }}</a>

        <div class="absolute left-1/2 top-[996px] -translate-x-1/2">
            <div class="h-px w-[1776px] bg-lum-espresso/16" data-lum-stay-intro-item data-lum-stay-intro-order="17"></div>
        </div>
        </div>

        <div class="relative h-[820px] overflow-hidden" data-lum-stay-intro-item data-lum-stay-intro-order="18">
            <img src="{{ $img('contact/hero.webp') }}" alt="" class="h-full w-full object-cover" width="1920" height="820" loading="eager">
        </div>
    </div>
</section>
