<header class="absolute left-[20px] top-0 z-50 h-[80px] w-[920px] border-b border-lum-ivory-40">
    <a href="/" class="absolute left-0 top-1/2 h-[32px] w-[84px] -translate-y-1/2">
        <img src="{{ asset('images/lum/hero/logo-lum-cream.svg') }}" alt="Lum" class="h-full w-full object-contain object-left" width="84" height="32">
    </a>

    <div class="absolute right-0 top-[24px] flex items-center gap-[10px]">
        <div class="relative">
            <button
                type="button"
                class="lum-icon-btn lum-icon-btn--ivory-filled-s"
                data-lum-lang-toggle
                aria-label="Language"
                aria-expanded="false"
                aria-controls="lum-lang-panel"
            >
                <img src="{{ asset('images/lum/hero/language.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </button>
            @include('lum.partials.language-switcher')
        </div>

        <a href="#" class="lum-btn-outline-ivory px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">take a break</a>

        <button type="button" class="lum-icon-btn lum-icon-btn--ivory-filled-s" aria-label="Contact">
            <img src="{{ asset('images/lum/hero/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>

        <button type="button" class="lum-burger-btn lum-burger-btn--ivory-compact flex w-[56px] items-center justify-center" aria-label="Menu" data-lum-menu-toggle aria-controls="lum-burger-menu" aria-expanded="false">
            <img src="{{ asset('images/lum/hero/burger.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
    </div>
</header>
