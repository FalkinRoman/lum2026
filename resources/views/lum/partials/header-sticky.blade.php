<header
    id="lum-sticky-header"
    class="lum-sticky-header fixed inset-x-0 top-0 z-[200] overflow-hidden"
    aria-hidden="true"
>
    <div class="lum-sticky-header__scaled origin-top-left">
        <div class="lum-sticky-header__inner">
            {{-- MOBILE --}}
            <div class="relative h-[80px] w-full border-b border-lum-espresso/16 bg-lum-ivory tab:hidden">
                <div class="absolute left-[20px] top-0 h-[80px] w-[335px]">
                    <a href="/" class="absolute left-0 top-1/2 h-[32px] w-[84px] -translate-y-1/2">
                        <img src="{{ asset('images/lum/menu/logo-lum-espresso.svg') }}" alt="Lum" class="h-full w-full object-contain object-left" width="84" height="32">
                    </a>

                    <button type="button" class="absolute right-0 top-1/2 flex w-[56px] -translate-y-1/2 items-center justify-center rounded-[50px] border border-lum-espresso bg-lum-ivory px-[20px]" aria-label="Menu" data-lum-menu-toggle aria-controls="lum-burger-menu" aria-expanded="false">
                        <img src="{{ asset('images/lum/hero/burger.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                    </button>

                    <a href="#" class="lum-btn-outline absolute right-[66px] top-1/2 -translate-y-1/2 px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">break</a>
                </div>
            </div>

            {{-- TABLET --}}
            <div class="relative hidden h-[80px] w-full border-b border-lum-espresso/16 bg-lum-ivory tab:block desk:hidden">
                <div class="absolute left-[20px] top-0 h-[80px] w-[920px]">
                    <a href="/" class="absolute left-0 top-1/2 h-[32px] w-[84px] -translate-y-1/2">
                        <img src="{{ asset('images/lum/menu/logo-lum-espresso.svg') }}" alt="Lum" class="h-full w-full object-contain object-left" width="84" height="32">
                    </a>

                    <div class="absolute right-0 top-[24px] flex items-center gap-[10px]">
                        <div class="relative">
                            <button
                                type="button"
                                class="flex items-center rounded-[44px] border border-lum-espresso p-[2px]"
                                data-lum-lang-toggle
                                aria-label="Language"
                                aria-expanded="false"
                                aria-controls="lum-lang-panel-sticky"
                            >
                                <img src="{{ asset('images/lum/hero/language.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                            </button>
                            @include('lum.partials.language-switcher', ['panelId' => 'lum-lang-panel-sticky'])
                        </div>

                        <a href="#" class="lum-btn-outline px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">take a break</a>

                        <button type="button" class="flex items-center rounded-[44px] bg-lum-espresso p-[2px]" aria-label="Contact">
                            <img src="{{ asset('images/lum/hero/arrow.svg') }}" alt="" class="size-[32px] brightness-0 invert" width="32" height="32">
                        </button>

                        <button type="button" class="flex w-[56px] items-center justify-center rounded-[50px] border border-lum-espresso bg-lum-ivory px-[20px]" aria-label="Menu" data-lum-menu-toggle aria-controls="lum-burger-menu" aria-expanded="false">
                            <img src="{{ asset('images/lum/hero/burger.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                        </button>
                    </div>
                </div>
            </div>

            {{-- DESKTOP --}}
            <div class="relative hidden h-[132px] w-full border-b border-lum-espresso/16 bg-lum-ivory desk:block">
                <div class="absolute left-1/2 top-0 h-[132px] w-[1776px] -translate-x-1/2">
                    <button type="button" class="absolute left-0 top-1/2 flex -translate-y-1/2 items-center rounded-[50px] border border-lum-espresso bg-lum-ivory px-[20px] py-[2px]" aria-label="Menu" data-lum-menu-toggle aria-controls="lum-burger-menu" aria-expanded="false">
                        <img src="{{ asset('images/lum/hero/burger.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                    </button>

                    <div class="absolute left-[112px] top-1/2 h-[18px] w-px -translate-y-1/2 bg-lum-espresso/16"></div>

                    <nav class="absolute left-[153px] top-[54px] flex items-start gap-[40px] lum-text-2 font-medium text-lum-espresso">
                        <a href="#" class="flex flex-col items-center gap-[5px]">
                            <span>Stay</span>
                            <img src="{{ asset('images/lum/ui/point-active.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                        </a>
                        <a href="#" class="flex h-[25px] items-center">Dining</a>
                        <a href="#" class="flex h-[25px] items-center">Relax</a>
                        <a href="#" class="flex h-[25px] items-center">Discover</a>
                    </nav>

                    <a href="/" class="absolute left-1/2 top-1/2 h-[40px] w-[105px] -translate-x-1/2 -translate-y-1/2">
                        <img src="{{ asset('images/lum/menu/logo-lum-espresso.svg') }}" alt="Lum" class="h-[40px] w-[105px]" width="105" height="40">
                    </a>

                    <div class="absolute right-0 top-[48px] flex items-center gap-[10px]">
                        <button type="button" class="flex items-center rounded-[50px] border border-lum-espresso p-[2px]" aria-label="Language">
                            <img src="{{ asset('images/lum/hero/language.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                        </button>
                        <a href="#" class="lum-btn-outline">take a break</a>
                        <button type="button" class="flex items-center rounded-[50px] bg-lum-espresso p-[2px]" aria-label="Contact">
                            <img src="{{ asset('images/lum/hero/arrow.svg') }}" alt="" class="size-[32px] brightness-0 invert" width="32" height="32">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
