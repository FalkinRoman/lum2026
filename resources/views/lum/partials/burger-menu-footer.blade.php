<div class="lum-burger-menu__footer bg-lum-green text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-ivory tab:text-[16px] tab:leading-[25px] tab:tracking-[0.16px]">
    {{-- MOBILE — Figma 160:422 h 178 --}}
    <div class="relative h-[178px] w-full tab:hidden">
        <div class="absolute left-[20px] top-[20px] flex flex-col gap-[6px]">
            <span class="text-lum-ivory-40">{{ __('lum.burger_footer.reception') }}</span>
            <a href="tel:+94779296087" class="text-lum-ivory">+94 (779) 296-087</a>
        </div>
        <div class="absolute left-[20px] top-[74px] flex flex-col gap-[6px]">
            <span class="text-lum-ivory-40">{{ __('lum.burger_footer.email') }}</span>
            <a href="mailto:dimacake@gmail.com" class="text-lum-ivory">dimacake@gmail.com</a>
        </div>
        <div class="absolute left-[20px] top-[128px] flex flex-col gap-[6px]">
            <span class="text-lum-ivory-40">{{ __('lum.burger_footer.social') }}</span>
            <div class="flex gap-[12px] whitespace-nowrap text-lum-ivory">
                <a href="#">{{ __('lum.burger_footer.instagram') }}</a>
                <span class="text-lum-ivory-40">/</span>
                <a href="#">{{ __('lum.burger_footer.whatsapp') }}</a>
                <span class="text-lum-ivory-40">/</span>
                <a href="#">{{ __('lum.burger_footer.telegram') }}</a>
            </div>
        </div>
    </div>

    {{-- TABLET + DESKTOP --}}
    <div class="relative hidden h-[90px] px-[20px] py-[20px] tab:block desk:h-[104px] desk:px-[72px] desk:py-[27px]">
        <div class="absolute left-[20px] top-[20px] flex flex-col gap-[6px] tab:gap-0 desk:left-[72px] desk:top-[27px] desk:gap-0">
            <span class="text-lum-ivory-40 tab:leading-[25px] desk:leading-[25px]">{{ __('lum.burger_footer.reception') }}</span>
            <a href="tel:+94779296087" class="text-lum-ivory tab:leading-[25px] desk:leading-[25px]">+94 (779) 296-087</a>
        </div>
        <div class="absolute left-1/2 top-[20px] flex -translate-x-1/2 flex-col gap-[6px] tab:top-[20px] desk:left-[293px] desk:top-[27px] desk:translate-x-0">
            <span class="text-lum-ivory-40 tab:leading-[25px] desk:leading-[25px]">{{ __('lum.burger_footer.email') }}</span>
            <a href="mailto:dimacake@gmail.com" class="text-lum-ivory tab:leading-[25px] desk:leading-[25px]">dimacake@gmail.com</a>
        </div>
        <div class="absolute right-[20px] top-[20px] flex flex-col gap-[6px] tab:left-[596px] tab:right-auto tab:top-[20px] desk:left-[992px] desk:top-[27px]">
            <span class="text-lum-ivory-40 tab:leading-[25px] desk:leading-[25px]">{{ __('lum.burger_footer.social') }}</span>
            <div class="flex gap-[16px] text-lum-ivory tab:leading-[25px] desk:leading-[25px]">
                <a href="#">{{ __('lum.burger_footer.instagram') }}</a>
                <span class="text-lum-ivory-40">/</span>
                <a href="#">{{ __('lum.burger_footer.whatsapp') }}</a>
                <span class="text-lum-ivory-40">/</span>
                <a href="#">{{ __('lum.burger_footer.telegram') }}</a>
            </div>
        </div>
    </div>
</div>
