<div class="lum-burger-menu__footer bg-lum-green text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-ivory tab:text-[16px] tab:leading-[25px] tab:tracking-[0.16px]">
    {{-- MOBILE — Figma 160:422 h 178 --}}
    <div class="relative h-[178px] w-full tab:hidden">
        <div class="absolute left-[20px] top-[20px] flex flex-col gap-[6px]">
            <span class="text-lum-ivory-40">{{ __('lum.burger_footer.reception') }}</span>
            @include('lum.partials.link-footer-nav', [
                'label' => \App\Support\Site::phone(),
                'href' => \App\Support\Site::phoneHref(),
                'variant' => 'line',
                'classes' => 'text-lum-ivory',
            ])
        </div>
        <div class="absolute left-[20px] top-[74px] flex flex-col gap-[6px]">
            <span class="text-lum-ivory-40">{{ __('lum.burger_footer.email') }}</span>
            @include('lum.partials.link-footer-nav', [
                'label' => \App\Support\Site::email(),
                'href' => \App\Support\Site::emailHref(),
                'variant' => 'line',
                'classes' => 'text-lum-ivory',
            ])
        </div>
        <div class="absolute left-[20px] top-[128px] flex flex-col gap-[6px]">
            <span class="text-lum-ivory-40">{{ __('lum.burger_footer.social') }}</span>
            <div class="flex items-baseline gap-[12px] whitespace-nowrap text-lum-ivory">
                @include('lum.partials.link-footer-nav', [
                    'label' => __('lum.burger_footer.instagram'),
                    'href' => \App\Support\Site::instagramUrl(),
                    'variant' => 'line',
                    'classes' => 'text-lum-ivory',
                ])
                <span class="text-lum-ivory-40">/</span>
                @include('lum.partials.link-footer-nav', [
                    'label' => __('lum.burger_footer.whatsapp'),
                    'href' => \App\Support\Site::whatsappUrl(),
                    'variant' => 'line',
                    'classes' => 'text-lum-ivory',
                ])
                <span class="text-lum-ivory-40">/</span>
                @include('lum.partials.link-footer-nav', [
                    'label' => __('lum.burger_footer.telegram'),
                    'href' => \App\Support\Site::telegramUrl(),
                    'variant' => 'line',
                    'classes' => 'text-lum-ivory',
                ])
            </div>
        </div>
    </div>

    {{-- TABLET + DESKTOP — flex so phone/email never clip under fixed height --}}
    <div class="hidden w-full items-start justify-between gap-[24px] px-[20px] py-[20px] tab:flex desk:px-[72px] desk:py-[27px]">
        <div class="flex shrink-0 flex-col gap-[6px] tab:gap-0">
            <span class="text-lum-ivory-40 tab:leading-[25px] desk:leading-[25px]">{{ __('lum.burger_footer.reception') }}</span>
            @include('lum.partials.link-footer-nav', [
                'label' => \App\Support\Site::phone(),
                'href' => \App\Support\Site::phoneHref(),
                'variant' => 'line',
                'classes' => 'text-lum-ivory tab:leading-[25px] desk:leading-[25px]',
            ])
        </div>
        <div class="flex shrink-0 flex-col gap-[6px] tab:gap-0">
            <span class="text-lum-ivory-40 tab:leading-[25px] desk:leading-[25px]">{{ __('lum.burger_footer.email') }}</span>
            @include('lum.partials.link-footer-nav', [
                'label' => \App\Support\Site::email(),
                'href' => \App\Support\Site::emailHref(),
                'variant' => 'line',
                'classes' => 'text-lum-ivory tab:leading-[25px] desk:leading-[25px]',
            ])
        </div>
        <div class="flex min-w-0 flex-col gap-[6px] tab:gap-0">
            <span class="text-lum-ivory-40 tab:leading-[25px] desk:leading-[25px]">{{ __('lum.burger_footer.social') }}</span>
            <div class="flex flex-wrap items-baseline gap-[16px] text-lum-ivory tab:leading-[25px] desk:leading-[25px]">
                @include('lum.partials.link-footer-nav', [
                    'label' => __('lum.burger_footer.instagram'),
                    'href' => \App\Support\Site::instagramUrl(),
                    'variant' => 'line',
                    'classes' => 'text-lum-ivory',
                ])
                <span class="text-lum-ivory-40">/</span>
                @include('lum.partials.link-footer-nav', [
                    'label' => __('lum.burger_footer.whatsapp'),
                    'href' => \App\Support\Site::whatsappUrl(),
                    'variant' => 'line',
                    'classes' => 'text-lum-ivory',
                ])
                <span class="text-lum-ivory-40">/</span>
                @include('lum.partials.link-footer-nav', [
                    'label' => __('lum.burger_footer.telegram'),
                    'href' => \App\Support\Site::telegramUrl(),
                    'variant' => 'line',
                    'classes' => 'text-lum-ivory',
                ])
            </div>
        </div>
    </div>
</div>
