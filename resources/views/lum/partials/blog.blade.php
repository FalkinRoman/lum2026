<section class="lum-container relative h-[1274px] bg-lum-ivory">
    <img src="{{ $img('blog/top-wave.svg') }}" alt="" class="absolute left-[72px] top-0 w-[1776px]" width="1776" height="45">

    <div class="absolute left-1/2 top-[160px] flex -translate-x-1/2 items-center gap-[12px]">
        <img src="{{ $img('blog/deco-left.svg') }}" alt="" class="w-[108px] rotate-180 scale-y-[-1]" width="108" height="2">
        <h2 class="lum-heading-1 font-medium italic whitespace-nowrap text-lum-espresso">explore. inspire. escape</h2>
        <img src="{{ $img('blog/deco-right.svg') }}" alt="" class="w-[108px]" width="108" height="2">
    </div>

    <div class="absolute left-1/2 top-[276px] -translate-x-1/2 -rotate-[1.4deg] bg-lum-espresso px-[32px] py-[12px]">
        <span class="lum-headline text-lum-ivory uppercase">BLOG</span>
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
                    <p class="lum-heading-3 text-lum-espresso">
                        our restaurant & bar<br>
                        is open daily from<br>
                        <span class="font-normal italic">9 am to 9 pm.</span>
                    </p>
                    <a href="#" class="lum-text-2 relative mt-[24px] font-medium text-lum-green">
                        Read More
                        <img src="{{ $img('blog/underline.svg') }}" alt="" class="absolute left-1/2 top-[26px] w-[79px] -translate-x-1/2" width="79" height="2">
                    </a>
                </div>
            </article>
        @endforeach
    </div>
</section>
