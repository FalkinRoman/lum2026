<section class="lum-container relative h-[1527px] bg-lum-ivory">
    <img src="{{ $img('interior/logomark.svg') }}" alt="" class="absolute left-1/2 top-[80px] size-[64px] -translate-x-1/2" width="64" height="64">

    <div class="absolute left-1/2 top-[208px] -translate-x-1/2 text-center text-lum-espresso">
        <p class="lum-heading-1 font-medium italic tracking-[-1.76px]">view of the</p>
        <p class="lum-heading-1 font-normal tracking-[-1.76px]">INTERIOR</p>
    </div>

    <div class="absolute left-1/2 top-[328.64px] h-[80px] w-[440px] -translate-x-1/2 -rotate-[1.4deg] bg-lum-orange opacity-56 shadow-[3px_3px_0_rgba(0,0,0,0.25)]"></div>

    <div class="absolute left-1/2 top-[484px] flex -translate-x-1/2 flex-nowrap items-center gap-[10px]">
        @foreach (['✓ONE—STORY' => true, 'TWO—STORY' => false, 'KITCHEN' => false, 'BEDROOM' => false, 'BATHROOM' => false, 'BASEMENT' => false] as $label => $active)
            <button type="button" @class([
                'inline-flex h-[40px] shrink-0 items-center justify-center px-[18px] lum-text-2 font-medium whitespace-nowrap',
                'bg-lum-ground text-lum-ivory' => $active,
                'border border-lum-ground bg-transparent text-lum-ground' => ! $active,
            ])>{{ $label }}</button>
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
        <p class="font-serif text-[20px] font-medium leading-[24px] tracking-[-0.4px] text-lum-espresso">
            03 <span class="text-lum-espresso-40">/ 07</span>
        </p>
    </div>
</section>
