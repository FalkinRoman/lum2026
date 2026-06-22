@php
    $interiorTabs = ['✓ONE—STORY' => true, 'TWO—STORY' => false, 'KITCHEN' => false, 'BEDROOM' => false, 'BATHROOM' => false, 'BASEMENT' => false];
@endphp

<section class="lum-container relative h-[827px] bg-lum-ivory tab:h-[1317px] desk:h-[1527px]">
    {{-- MOBILE --}}
    <div class="relative h-full tab:hidden">
        <img src="{{ $img('interior/logomark.svg') }}" alt="" class="absolute left-1/2 top-[45px] size-[32px] -translate-x-1/2" width="32" height="32">
        <div class="absolute left-1/2 top-[107px] -translate-x-1/2 text-center text-lum-espresso">
            <p class="font-serif text-[36px] font-medium italic leading-[45px] tracking-[-0.72px]">view of the</p>
            <p class="font-serif text-[36px] leading-[45px] tracking-[-0.72px]">INTERIOR</p>
        </div>
        <div class="absolute left-1/2 top-[172px] h-[41px] w-[201px] -translate-x-1/2 -rotate-[1.4deg] bg-lum-orange opacity-56 shadow-[3px_3px_0_rgba(0,0,0,0.25)]"></div>
        <div class="absolute left-[57px] top-[252px] flex w-[260px] flex-wrap items-center justify-center gap-[8px]">
            @foreach ($interiorTabs as $label => $active)
                <button type="button" @class(['inline-flex h-[32px] shrink-0 items-center justify-center px-[14px] text-[14px] leading-[22px] font-medium whitespace-nowrap', 'bg-lum-ground text-lum-ivory' => $active, 'border border-lum-ground bg-transparent text-lum-ground' => ! $active])>{{ $label }}</button>
            @endforeach
        </div>
        <img src="{{ $img('interior/left.jpg') }}" alt="" class="absolute left-0 top-[388px] h-[260px] w-full object-cover shadow-[3px_3px_0_rgba(0,0,0,0.25)]" width="375" height="260">
        <button type="button" class="absolute left-[143px] top-[628px] flex size-[40px] rotate-90 items-center justify-center rounded-[50px] bg-lum-ivory p-[8px]" aria-label="Previous">
            <img src="{{ $img('interior/arrow.svg') }}" alt="" class="size-[24px]" width="24" height="24">
        </button>
        <button type="button" class="absolute left-[193px] top-[628px] flex size-[40px] -scale-y-100 rotate-90 items-center justify-center rounded-[50px] bg-lum-ivory p-[8px]" aria-label="Next">
            <img src="{{ $img('interior/arrow.svg') }}" alt="" class="size-[24px]" width="24" height="24">
        </button>
        <div class="absolute left-1/2 top-[692px] flex w-[280px] -translate-x-1/2 flex-col items-center gap-[16px]">
            <div class="flex w-full items-center justify-center gap-[8px]">
                @for ($i = 0; $i < 7; $i++)
                    @if ($i === 2)
                        <img src="{{ $img('interior/slider-active.svg') }}" alt="" class="h-[19px] w-[33px]" width="33" height="19">
                    @else
                        <span class="h-px w-[33px] bg-lum-espresso opacity-40"></span>
                    @endif
                @endfor
            </div>
            <p class="font-serif text-[16px] font-medium leading-[20px] tracking-[-0.16px] text-lum-espresso">03 <span class="text-lum-espresso-40">/ 07</span></p>
        </div>
    </div>

    {{-- TABLET --}}
    <div class="relative hidden h-full tab:block desk:hidden">
        <img src="{{ $img('interior/logomark.svg') }}" alt="" class="absolute left-1/2 top-[61px] size-[40px] -translate-x-1/2" width="40" height="40">
        <div class="absolute left-1/2 top-[145px] -translate-x-1/2 text-center text-lum-espresso">
            <p class="font-serif text-[52px] font-medium italic leading-[52px] tracking-[-1.04px]">view of the</p>
            <p class="font-serif text-[52px] leading-[52px] tracking-[-1.04px]">INTERIOR</p>
        </div>
        <div class="absolute left-1/2 top-[217px] h-[71px] w-[281px] -translate-x-1/2 -rotate-[1.4deg] bg-lum-orange opacity-56 shadow-[3px_3px_0_rgba(0,0,0,0.25)]"></div>
        <div class="absolute left-[127px] top-[325px] flex flex-nowrap items-center gap-[10px]">
            @foreach ($interiorTabs as $label => $active)
                <button type="button" @class(['inline-flex h-[32px] shrink-0 items-center justify-center px-[14px] text-[14px] leading-[22px] font-medium whitespace-nowrap', 'bg-lum-ground text-lum-ivory' => $active, 'border border-lum-ground bg-transparent text-lum-ground' => ! $active])>{{ $label }}</button>
            @endforeach
        </div>
        <img src="{{ $img('interior/left.jpg') }}" alt="" class="absolute left-0 top-[421px] h-[641px] w-full object-cover shadow-[3px_3px_0_rgba(0,0,0,0.25)]" width="960" height="641">
        <button type="button" class="absolute left-[414px] top-[1034px] flex size-[56px] rotate-90 items-center justify-center rounded-[50px] bg-lum-ivory p-[12px]" aria-label="Previous">
            <img src="{{ $img('interior/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
        <button type="button" class="absolute left-[490px] top-[1034px] flex size-[56px] -scale-y-100 rotate-90 items-center justify-center rounded-[50px] bg-lum-ivory p-[12px]" aria-label="Next">
            <img src="{{ $img('interior/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
        <div class="absolute left-1/2 top-[1134px] flex w-[378px] -translate-x-1/2 flex-col items-center gap-[24px]">
            <div class="flex w-full items-center justify-center gap-[14px]">
                @for ($i = 0; $i < 7; $i++)
                    @if ($i === 2)
                        <img src="{{ $img('interior/slider-active.svg') }}" alt="" class="h-[19px] w-[42px]" width="42" height="19">
                    @else
                        <span class="h-px w-[42px] bg-lum-espresso opacity-40"></span>
                    @endif
                @endfor
            </div>
            <p class="font-serif text-[20px] font-medium leading-[24px] tracking-[-0.4px] text-lum-espresso">03 <span class="text-lum-espresso-40">/ 07</span></p>
        </div>
    </div>

    {{-- DESKTOP (не трогаем) --}}
    <div class="relative hidden h-full desk:block">
        <img src="{{ $img('interior/logomark.svg') }}" alt="" class="absolute left-1/2 top-[80px] size-[64px] -translate-x-1/2" width="64" height="64">
        <div class="absolute left-1/2 top-[208px] -translate-x-1/2 text-center text-lum-espresso">
            <p class="lum-heading-1 font-medium italic tracking-[-1.76px]">view of the</p>
            <p class="lum-heading-1 font-normal tracking-[-1.76px]">INTERIOR</p>
        </div>
        <div class="absolute left-1/2 top-[328.64px] h-[80px] w-[440px] -translate-x-1/2 -rotate-[1.4deg] bg-lum-orange opacity-56 shadow-[3px_3px_0_rgba(0,0,0,0.25)]"></div>
        <div class="absolute left-1/2 top-[484px] flex -translate-x-1/2 flex-nowrap items-center gap-[10px]">
            @foreach ($interiorTabs as $label => $active)
                <button type="button" @class(['inline-flex h-[40px] shrink-0 items-center justify-center px-[18px] lum-text-2 font-medium whitespace-nowrap', 'bg-lum-ground text-lum-ivory' => $active, 'border border-lum-ground bg-transparent text-lum-ground' => ! $active])>{{ $label }}</button>
            @endforeach
        </div>
        <img src="{{ $img('interior/left.jpg') }}" alt="" class="absolute left-0 top-[605px] h-[620px] w-[928px] object-cover shadow-[3px_3px_0_rgba(0,0,0,0.25)]" width="928" height="620">
        <div class="absolute left-[992px] top-[604px] h-[620px] w-[928px] overflow-hidden shadow-[3px_3px_0_rgba(0,0,0,0.25)]">
            <img src="{{ $img('interior/right.jpg') }}" alt="" class="h-full w-full object-cover" width="928" height="620">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[rgba(22,5,5,0.48)]"></div>
        </div>
        <button type="button" class="absolute left-[72px] top-[884px] flex size-[64px] rotate-90 items-center justify-center rounded-[50px] bg-lum-ivory p-[16px]" aria-label="Previous">
            <img src="{{ $img('interior/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
        <button type="button" class="absolute left-[1784px] top-[884px] flex size-[64px] -scale-y-100 rotate-90 items-center justify-center rounded-[50px] bg-lum-ivory p-[16px]" aria-label="Next">
            <img src="{{ $img('interior/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
        <div class="absolute left-[771px] top-[1300px] flex w-[378px] flex-col items-center gap-[24px]">
            <div class="flex w-full items-center justify-center gap-[14px]">
                @for ($i = 0; $i < 7; $i++)
                    @if ($i === 2)
                        <img src="{{ $img('interior/slider-active.svg') }}" alt="" class="h-[19px] w-[42px]" width="42" height="19">
                    @else
                        <span class="h-px w-[42px] bg-lum-espresso opacity-40"></span>
                    @endif
                @endfor
            </div>
            <p class="font-serif text-[20px] font-medium leading-[24px] tracking-[-0.4px] text-lum-espresso">03 <span class="text-lum-espresso-40">/ 07</span></p>
        </div>
    </div>
</section>
