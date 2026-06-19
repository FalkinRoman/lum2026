<section class="lum-container relative h-[1299px] bg-lum-ivory">
    <p class="lum-script pointer-events-none absolute left-[195px] top-[150px] text-[73px] leading-none tracking-[3.65px] text-lum-green">shine</p>
    <p class="lum-script pointer-events-none absolute left-[1091px] top-[455px] rotate-[9deg] text-[73px] leading-none tracking-[3.65px] text-lum-green">relax</p>
    <p class="lum-script pointer-events-none absolute left-[1291px] top-[-20px] -rotate-[10deg] text-[73px] leading-none tracking-[3.65px] text-lum-green">impressions</p>

    @foreach ([
        ['left' => '216px', 'top' => '362px', 'rotate' => '13.5deg', 'photo' => 'photo-1.jpg', 'date' => '06.08.2023'],
        ['left' => '787px', 'top' => '109px', 'rotate' => '-5.5deg', 'photo' => 'photo-2.jpg', 'date' => '06.01.2024'],
        ['left' => '1463px', 'top' => '392px', 'rotate' => '-1deg', 'photo' => 'photo-3.jpg', 'date' => '07.03.2023'],
    ] as $polaroid)
        <div class="absolute h-[425px] w-[301px]" style="left: {{ $polaroid['left'] }}; top: {{ $polaroid['top'] }}; transform: rotate({{ $polaroid['rotate'] }});">
            <img src="{{ $img('polaroids/frame.svg') }}" alt="" class="absolute inset-0 w-full drop-shadow-[1px_1px_0_rgba(0,0,0,0.25)]" width="301" height="425">
            <p class="absolute left-0 right-0 top-[18px] text-center font-sans text-[14px] leading-none tracking-[0.6px] text-lum-espresso">{{ $polaroid['date'] }}</p>
            <img src="{{ $img('polaroids/' . $polaroid['photo']) }}" alt="" class="absolute left-[14px] top-[38px] h-[266px] w-[273px] object-cover" width="273" height="266">
            <p class="lum-script absolute bottom-[28px] left-0 right-0 px-[12px] text-center text-[22px] leading-[24px] tracking-[1.1px] text-lum-green">share your impressions</p>
        </div>
    @endforeach

    <div class="absolute left-[80px] top-[693px] flex w-[1760px] flex-col items-center gap-[64px]">
        <div class="flex flex-col items-center gap-[24px]">
            <img src="{{ $img('ui/dot.svg') }}" alt="" class="size-[12px]" width="12" height="12">
            <div class="text-center">
                <h2 class="lum-heading-1 text-lum-espresso">
                    hard to find,<br>
                    <span class="font-medium italic">hard to leave</span>
                </h2>
                <p class="lum-body mx-auto mt-[44px] max-w-[760px] text-lum-espresso">
                    Just a few hours from the airport. Light years away from the crowds.
                    Here you find the true Sri Lanka. And a small resort with a big view, a
                    great restaurant, and a special sense of calm. Welcome to The Lum.
                </p>
            </div>
        </div>
        <a href="#villas" class="lum-btn-dark">explore our villas</a>
    </div>

    <div class="lum-divider absolute bottom-0 left-[72px]"></div>
</section>
