<div class="lum-burger-menu__footer bg-lum-green text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-ivory tab:text-[16px] tab:leading-[25px] tab:tracking-[0.16px]">
    {{-- MOBILE — Figma 160:422 h 178 --}}
    <div class="relative h-[178px] w-full tab:hidden">
        <div class="absolute left-[20px] top-[20px] flex flex-col gap-[6px]">
            <span class="text-lum-ivory-40">{{ __('lum.burger_footer.reception') }}</span>
            @include('lum.partials.link-footer-nav', [
                'label' => '+94 (779) 296-087',
                'href' => 'tel:+94779296087',
                'variant' => 'line',
                'classes' => 'text-lum-ivory',
            ])
        </div>
        <div class="absolute left-[20px] top-[74px] flex flex-col gap-[6px]">
            <span class="text-lum-ivory-40">{{ __('lum.burger_footer.email') }}</span>
            @include('lum.partials.link-footer-nav', [
                'label' => 'dimacake@gmail.com',
                'href' => 'mailto:dimacake@gmail.com',
                'variant' => 'line',
                'classes' => 'text-lum-ivory',
            ])
        </div>
        <div class="absolute left-[20px] top-[128px] flex flex-col gap-[6px]">
            <span class="text-lum-ivory-40">{{ __('lum.burger_footer.social') }}</span>
            <div class="flex items-baseline gap-[12px] whitespace-nowrap text-lum-ivory">
                @include('lum.partials.link-footer-nav', [
                    'label' => __('lum.burger_footer.instagram'),
                    'href' => '#',
                    'variant' => 'line',
                    'classes' => 'text-lum-ivory',
                ])
                <span class="text-lum-ivory-40">/</span>
                @include('lum.partials.link-footer-nav', [
                    'label' => __('lum.burger_footer.whatsapp'),
                    'href' => '#',
                    'variant' => 'line',
                    'classes' => 'text-lum-ivory',
                ])
                <span class="text-lum-ivory-40">/</span>
                @include('lum.partials.link-footer-nav', [
                    'label' => __('lum.burger_footer.telegram'),
                    'href' => '#',
                    'variant' => 'line',
                    'classes' => 'text-lum-ivory',
                ])
            </div>
        </div>
    </div>

    {{-- TABLET + DESKTOP --}}
    <div class="relative hidden h-[90px] px-[20px] py-[20px] tab:block desk:h-[104px] desk:px-[72px] desk:py-[27px]">
        <div class="absolute left-[20px] top-[20px] flex flex-col gap-[6px] tab:gap-0 desk:left-[72px] desk:top-[27px] desk:gap-0">
            <span class="text-lum-ivory-40 tab:leading-[25px] desk:leading-[25px]">{{ __('lum.burger_footer.reception') }}</span>
            @include('lum.partials.link-footer-nav', [
                'label' => '+94 (779) 296-087',
                'href' => 'tel:+94779296087',
                'variant' => 'line',
                'classes' => 'text-lum-ivory tab:leading-[25px] desk:leading-[25px]',
            ])
        </div>
        <div class="absolute left-1/2 top-[20px] flex -translate-x-1/2 flex-col gap-[6px] tab:top-[20px] desk:left-[293px] desk:top-[27px] desk:translate-x-0">
            <span class="text-lum-ivory-40 tab:leading-[25px] desk:leading-[25px]">{{ __('lum.burger_footer.email') }}</span>
            @include('lum.partials.link-footer-nav', [
                'label' => 'dimacake@gmail.com',
                'href' => 'mailto:dimacake@gmail.com',
                'variant' => 'line',
                'classes' => 'text-lum-ivory tab:leading-[25px] desk:leading-[25px]',
            ])
        </div>
        <div class="absolute right-[20px] top-[20px] flex flex-col gap-[6px] tab:left-[596px] tab:right-auto tab:top-[20px] desk:left-[992px] desk:top-[27px]">
            <span class="text-lum-ivory-40 tab:leading-[25px] desk:leading-[25px]">{{ __('lum.burger_footer.social') }}</span>
            <div class="flex items-baseline gap-[16px] text-lum-ivory tab:leading-[25px] desk:leading-[25px]">
                @include('lum.partials.link-footer-nav', [
                    'label' => __('lum.burger_footer.instagram'),
                    'href' => '#',
                    'variant' => 'line',
                    'classes' => 'text-lum-ivory',
                ])
                <span class="text-lum-ivory-40">/</span>
                @include('lum.partials.link-footer-nav', [
                    'label' => __('lum.burger_footer.whatsapp'),
                    'href' => '#',
                    'variant' => 'line',
                    'classes' => 'text-lum-ivory',
                ])
                <span class="text-lum-ivory-40">/</span>
                @include('lum.partials.link-footer-nav', [
                    'label' => __('lum.burger_footer.telegram'),
                    'href' => '#',
                    'variant' => 'line',
                    'classes' => 'text-lum-ivory',
                ])
            </div>
        </div>
    </div>
</div>
