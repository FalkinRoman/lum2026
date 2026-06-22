<section class="lum-container relative h-[777px] bg-lum-ivory tab:h-[1244px] desk:h-[1274px]">
    {{-- MOBILE --}}
    <div class="relative h-full tab:hidden">
        <img src="{{ $img('blog/top-wave.svg') }}" alt="" class="absolute left-[20px] top-0 w-[335px]" width="335" height="45">
        <div class="absolute left-1/2 top-[67px] w-[258px] -translate-x-1/2 text-center">
            <h2 class="font-serif text-[36px] font-medium italic leading-[45px] text-lum-espresso">explore. inspire. escape</h2>
        </div>
        <div class="absolute left-1/2 top-[181px] -translate-x-1/2 -rotate-[1.4deg] bg-lum-espresso px-[24px] py-[8px]">
            <span class="text-[18px] font-medium uppercase leading-[26px] tracking-[2.4px] text-lum-ivory">BLOG</span>
        </div>
        <div class="absolute left-0 top-[201px] flex w-full gap-[10px] overflow-x-auto px-[20px]">
            @foreach (range(1, 4) as $i)
                <article class="w-[240px] shrink-0">
                    <div class="relative h-[240px] w-[240px] overflow-hidden">
                        <img src="{{ $img('blog/surfing.jpg') }}" alt="" class="h-full w-full object-cover" width="240" height="240">
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[rgba(57,54,46,0.74)]"></div>
                    </div>
                    <div class="flex h-[192px] w-[240px] flex-col items-center bg-lum-sand px-[20px] pt-[6px] text-center">
                        <img src="{{ $img('ui/dot.svg') }}" alt="" class="mb-[12px] size-[6px]" width="6" height="6">
                        <p class="mb-[16px] text-[12px] font-medium uppercase leading-[12px] tracking-[0.6px]">SURFING</p>
                        <p class="font-serif text-[20px] leading-[24px] tracking-[0.2px] text-lum-espresso">our restaurant & bar<br>is open daily from<br><span class="font-normal italic">9 am to 9 pm.</span></p>
                        <a href="#" class="relative mt-[16px] text-[12px] font-medium leading-[12px] text-lum-green">Read More<img src="{{ $img('blog/underline.svg') }}" alt="" class="absolute left-1/2 top-[16px] w-[63px] -translate-x-1/2" width="63" height="2"></a>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="absolute left-1/2 top-[657px] flex -translate-x-1/2 gap-[10px]">
            <button type="button" class="flex size-[40px] rotate-90 items-center justify-center rounded-[50px] bg-lum-ground p-[8px]" aria-label="Previous">
                <img src="{{ $img('interior/arrow.svg') }}" alt="" class="size-[24px]" width="24" height="24">
            </button>
            <button type="button" class="flex size-[40px] -scale-y-100 rotate-90 items-center justify-center rounded-[50px] bg-lum-ground p-[8px]" aria-label="Next">
                <img src="{{ $img('interior/arrow.svg') }}" alt="" class="size-[24px]" width="24" height="24">
            </button>
        </div>
    </div>

    {{-- TABLET --}}
    <div class="relative hidden h-full tab:block desk:hidden">
        <img src="{{ $img('blog/top-wave.svg') }}" alt="" class="absolute left-[20px] top-0 w-[920px]" width="920" height="45">
        <div class="absolute left-1/2 top-[108px] -translate-x-1/2">
            <div class="flex items-center justify-center gap-[12px]">
                <img src="{{ $img('blog/deco-left.svg') }}" alt="" class="w-[72px] rotate-180 scale-y-[-1]" width="72" height="2">
                <h2 class="font-serif text-[52px] font-medium italic leading-[52px] whitespace-nowrap text-lum-espresso">explore. inspire. escape</h2>
                <img src="{{ $img('blog/deco-right.svg') }}" alt="" class="w-[72px]" width="72" height="2">
            </div>
        </div>
        <div class="absolute left-1/2 top-[182px] -translate-x-1/2 -rotate-[1.4deg] bg-lum-espresso px-[28px] py-[10px]">
            <span class="text-[18px] font-medium uppercase leading-[26px] tracking-[2.4px] text-lum-ivory">BLOG</span>
        </div>
        <div class="absolute left-[20px] top-[287px] grid w-[920px] grid-cols-2 gap-[20px]">
            @foreach (range(1, 4) as $i)
                <article class="w-[450px]">
                    <div class="relative h-[450px] w-[450px] overflow-hidden">
                        <img src="{{ $img('blog/surfing.jpg') }}" alt="" class="h-full w-full object-cover" width="450" height="450">
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[rgba(57,54,46,0.74)]"></div>
                    </div>
                    <div class="flex h-[287px] w-[450px] flex-col items-center bg-lum-sand px-[32px] pt-[32px] text-center">
                        <img src="{{ $img('ui/dot.svg') }}" alt="" class="mb-[12px] size-[6px]" width="6" height="6">
                        <p class="lum-text-2 mb-[24px] font-medium uppercase">SURFING</p>
                        <p class="font-serif text-[28px] leading-[32px] tracking-[0.28px] text-lum-espresso">our restaurant & bar<br>is open daily from<br><span class="font-normal italic">9 am to 9 pm.</span></p>
                        <a href="#" class="lum-text-2 relative mt-[24px] font-medium text-lum-green">Read More<img src="{{ $img('blog/underline.svg') }}" alt="" class="absolute left-1/2 top-[26px] w-[79px] -translate-x-1/2" width="79" height="2"></a>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="absolute left-1/2 top-[1068px] flex -translate-x-1/2 gap-[10px]">
            <button type="button" class="flex size-[56px] rotate-90 items-center justify-center rounded-[50px] bg-lum-ground p-[12px]" aria-label="Previous">
                <img src="{{ $img('interior/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </button>
            <button type="button" class="flex size-[56px] -scale-y-100 rotate-90 items-center justify-center rounded-[50px] bg-lum-ground p-[12px]" aria-label="Next">
                <img src="{{ $img('interior/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </button>
        </div>
    </div>

    {{-- DESKTOP (не трогаем) --}}
    <div class="relative hidden h-full desk:block">
        <img src="{{ $img('blog/top-wave.svg') }}" alt="" class="absolute left-[72px] top-0 w-[1776px]" width="1776" height="45">
        <div class="absolute left-1/2 top-[160px] flex -translate-x-1/2 items-center gap-[12px]">
            <img src="{{ $img('blog/deco-left.svg') }}" alt="" class="w-[108px] rotate-180 scale-y-[-1]" width="108" height="2">
            <h2 class="lum-heading-1 font-medium italic whitespace-nowrap text-lum-espresso">explore. inspire. escape</h2>
            <img src="{{ $img('blog/deco-right.svg') }}" alt="" class="w-[108px]" width="108" height="2">
        </div>
        <div class="absolute left-1/2 top-[276px] -translate-x-1/2 -rotate-[1.4deg] bg-lum-espresso px-[32px] py-[12px]">
            <span class="lum-headline uppercase text-lum-ivory">BLOG</span>
        </div>
        <div class="absolute left-[72px] top-[398px] flex gap-[64px]">
            @foreach (range(1, 4) as $i)
                <article class="w-[396px] shrink-0">
                    <div class="relative h-[396px] w-[396px] overflow-hidden">
                        <img src="{{ $img('blog/surfing.jpg') }}" alt="" class="h-full w-full object-cover" width="396" height="396">
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[rgba(57,54,46,0.74)]"></div>
                    </div>
                    <div class="flex h-[320px] w-[396px] flex-col items-center bg-lum-sand px-[37px] pt-[44px] text-center">
                        <img src="{{ $img('ui/dot.svg') }}" alt="" class="mb-[12px] size-[6px]" width="6" height="6">
                        <p class="lum-text-2 mb-[24px] font-medium uppercase">SURFING</p>
                        <p class="lum-heading-3 text-lum-espresso">our restaurant & bar<br>is open daily from<br><span class="font-normal italic">9 am to 9 pm.</span></p>
                        <a href="#" class="lum-text-2 relative mt-[24px] font-medium text-lum-green">Read More<img src="{{ $img('blog/underline.svg') }}" alt="" class="absolute left-1/2 top-[26px] w-[79px] -translate-x-1/2" width="79" height="2"></a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
