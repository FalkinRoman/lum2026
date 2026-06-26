<div
    id="lum-burger-menu"
    class="lum-burger-menu fixed inset-0 z-[300] hidden"
    aria-hidden="true"
    role="dialog"
    aria-modal="true"
    aria-label="Menu"
>
    <div class="lum-burger-menu__scroll fixed inset-0 z-10 flex min-h-full flex-col overflow-y-auto overscroll-contain bg-black/32 backdrop-blur-[8px]">
        <div class="lum-burger-menu__drawer relative w-full shrink-0 overflow-hidden">
            <div class="lum-burger-menu__scaled flex flex-col origin-top-left">
                <div class="lum-burger-menu__panel relative bg-lum-ivory">
            {{-- MOBILE --}}
            <div class="relative h-[582px] w-full tab:hidden">
                <header class="absolute left-[20px] top-0 h-[80px] w-[335px] border-b border-lum-espresso/16">
                    <a href="/" class="absolute left-0 top-1/2 h-[32px] w-[84px] -translate-y-1/2">
                        <img src="{{ asset('images/lum/menu/logo-lum-espresso.svg') }}" alt="Lum" class="h-full w-full object-contain object-left" width="84" height="32">
                    </a>
                    <button type="button" class="lum-burger-btn lum-burger-btn--espresso-compact absolute right-0 top-1/2 flex w-[56px] -translate-y-1/2 items-center" data-lum-menu-close aria-label="Close menu">
                        <span class="flex size-[32px] shrink-0 items-center justify-center">
                            <img src="{{ asset('images/lum/menu/close.svg') }}" alt="" class="size-[13.060546875px]" width="13" height="13">
                        </span>
                    </button>
                    <a href="#" class="lum-btn-outline absolute right-[66px] top-1/2 -translate-y-1/2 px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">break</a>
                </header>

                <p class="absolute left-[20px] top-[104px] text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-espresso-40" data-lum-menu-reveal="1">Select Language</p>
                <div class="absolute right-[20px] top-[98px] flex gap-[10px]" data-lum-menu-reveal="1">
                    <button type="button" class="lum-tab lum-tab--s lum-tab--active">✓Ru</button>
                    <button type="button" class="lum-tab lum-tab--s lum-tab--inactive">En</button>
                </div>

                <nav class="absolute left-[20px] top-[146px] flex w-[160px] flex-col gap-[6px]" data-lum-menu-reveal="2">
                    <a href="/" class="flex items-center gap-[6px] font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso">
                        Home
                        <img src="{{ asset('images/lum/ui/point-active.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                    </a>
                    <a href="#" class="font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso">Shop</a>
                    <a href="#" class="font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso">Contacts</a>
                    <a href="#" class="font-serif text-[28px] leading-[28px] tracking-[-0.25px] text-lum-espresso">Blog</a>
                </nav>

                <div class="absolute left-[20px] top-[300px] h-px w-[335px] bg-lum-espresso/16" data-lum-menu-reveal="3"></div>

                <div class="absolute left-[20px] top-[325px] grid w-[335px] grid-cols-2 gap-x-[76px] gap-y-[12px] text-[14px] font-medium leading-[14px] tracking-[0.6px] text-lum-espresso" data-lum-menu-reveal="3">
                    <a href="#">Lum Residence</a>
                    <a href="#">Lum Villas</a>
                    <a href="#">Oculus</a>
                    <a href="#">Lum Ocean</a>
                </div>

                <div class="absolute left-[20px] top-[387px] h-[175px] w-[335px] overflow-hidden" data-lum-menu-reveal="4">
                    <img src="{{ asset('images/lum/menu/map.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-black/32"></div>
                    <div class="absolute left-1/2 top-1/2 flex w-[197px] -translate-x-1/2 -translate-y-1/2 flex-col items-center gap-[16px] text-center">
                        <p class="font-serif text-[22px] font-medium leading-[24px] tracking-[0.19px] text-lum-ivory">
                            Thiththagalla road,<br>Ahangama, Sri Lanka
                        </p>
                        <a href="#" class="lum-btn-ivory px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">SEE on map</a>
                    </div>
                </div>
            </div>

            {{-- TABLET --}}
            <div class="relative hidden h-[868px] w-full tab:block desk:hidden">
                <header class="absolute left-[20px] top-0 h-[80px] w-[920px] border-b border-lum-espresso/16">
                    <a href="/" class="absolute left-0 top-1/2 h-[32px] w-[84px] -translate-y-1/2">
                        <img src="{{ asset('images/lum/menu/logo-lum-espresso.svg') }}" alt="Lum" class="h-full w-full object-contain object-left" width="84" height="32">
                    </a>
                    <div class="absolute right-0 top-[24px] flex items-center gap-[10px]">
                        <button type="button" class="lum-icon-btn lum-icon-btn--espresso-outline" aria-label="Language">
                            <img src="{{ asset('images/lum/hero/language.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                        </button>
                        <a href="#" class="lum-btn-outline px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">take a break</a>
                        <button type="button" class="lum-icon-btn lum-icon-btn--espresso-filled" aria-label="Contact">
                            <img src="{{ asset('images/lum/hero/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                        </button>
                        <button type="button" class="lum-burger-btn lum-burger-btn--espresso-compact flex w-[56px] items-center justify-center" data-lum-menu-close aria-label="Close menu">
                            <span class="flex size-[32px] shrink-0 items-center justify-center">
                                <img src="{{ asset('images/lum/menu/close.svg') }}" alt="" class="size-[13.060546875px]" width="13" height="13">
                            </span>
                        </button>
                    </div>
                </header>

                <nav class="absolute left-[20px] top-[144px] flex w-[920px] flex-col gap-[6px]" data-lum-menu-reveal="2">
                    <a href="/" class="font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">Home</a>
                    <div class="flex flex-wrap items-center gap-[12px] font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">
                        <a href="#">Residence</a>
                        <span class="text-lum-espresso/16">/</span>
                        <a href="#">Oculus</a>
                        <span class="text-lum-espresso/16">/</span>
                        <a href="#">Ocean</a>
                        <img src="{{ asset('images/lum/ui/point-active.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                        <span class="text-lum-espresso/16">/</span>
                        <a href="#">Villas</a>
                    </div>
                    <a href="#" class="font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">Shop</a>
                    <a href="#" class="font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">Contacts</a>
                    <a href="#" class="font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso">Blog</a>
                </nav>

                <div class="absolute left-[20px] top-[368px] h-[480px] w-[920px] overflow-hidden bg-lum-green" data-lum-menu-reveal="4">
                    <img src="{{ asset('images/lum/menu/map.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-black/32"></div>
                    <div class="absolute bottom-[31px] left-[36px] font-serif text-[28px] font-medium leading-[34px] tracking-[0.36px] text-lum-ivory">
                        Thiththagalla road,<br>Ahangama, Sri Lanka
                    </div>
                    <a href="#" class="lum-btn-ivory absolute bottom-[36px] right-[36px] px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">SEE on map</a>
                </div>
            </div>

            {{-- DESKTOP --}}
            <div class="relative hidden h-[732px] w-full desk:block">
                <header class="absolute left-1/2 top-0 h-[132px] w-[1776px] -translate-x-1/2 border-b border-lum-espresso/16">
                    <button type="button" class="lum-burger-btn lum-burger-btn--espresso absolute left-0 top-1/2 flex -translate-y-1/2 items-center" data-lum-menu-close aria-label="Close menu">
                        <span class="flex size-[32px] shrink-0 items-center justify-center">
                            <img src="{{ asset('images/lum/menu/close.svg') }}" alt="" class="size-[13.060546875px]" width="13" height="13">
                        </span>
                    </button>
                    <div class="absolute left-[112px] top-1/2 h-[18px] w-px -translate-y-1/2 bg-lum-espresso/16"></div>
                    <nav class="absolute left-[153px] top-[54px] flex items-start gap-[40px] text-[16px] font-medium leading-[25px] tracking-[0.16px] text-lum-espresso">
                        <a href="#" class="lum-nav-link is-active">
                            <span>Stay</span>
                            <img src="{{ asset('images/lum/ui/point-active.svg') }}" alt="" class="lum-nav-link__dot" width="6" height="6">
                        </a>
                        <a href="#" class="lum-nav-link--inline">Dining</a>
                        <a href="#" class="lum-nav-link--inline">Relax</a>
                        <a href="#" class="lum-nav-link--inline">Discover</a>
                    </nav>
                    <a href="/" class="absolute left-1/2 top-1/2 h-[40px] w-[105px] -translate-x-1/2 -translate-y-1/2">
                        <img src="{{ asset('images/lum/menu/logo-lum-espresso.svg') }}" alt="Lum" class="h-[40px] w-[105px]" width="105" height="40">
                    </a>
                    <div class="absolute right-0 top-[48px] flex items-center gap-[10px]">
                        <button type="button" class="lum-icon-btn lum-icon-btn--espresso-outline" aria-label="Language">
                            <img src="{{ asset('images/lum/hero/language.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                        </button>
                        <a href="#" class="lum-btn-outline">take a break</a>
                        <button type="button" class="lum-icon-btn lum-icon-btn--espresso-filled" aria-label="Contact">
                            <img src="{{ asset('images/lum/hero/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                        </button>
                    </div>
                </header>

                <nav class="absolute left-[72px] top-[320px] flex flex-col" data-lum-menu-reveal="2">
                    <a href="/" class="font-serif text-[56px] leading-[68px] tracking-[-0.25px] text-lum-espresso">Home</a>
                    <div class="flex flex-wrap items-center gap-[16px] font-serif text-[56px] leading-[68px] tracking-[-0.25px] text-lum-espresso">
                        <a href="#">Residence</a>
                        <span class="text-lum-espresso/16">/</span>
                        <a href="#">Oculus</a>
                        <span class="text-lum-espresso/16">/</span>
                        <a href="#">Ocean</a>
                        <img src="{{ asset('images/lum/ui/point-active.svg') }}" alt="" class="size-[6px]" width="6" height="6">
                        <span class="text-lum-espresso/16">/</span>
                        <a href="#">Villas</a>
                    </div>
                    <a href="#" class="font-serif text-[56px] leading-[68px] tracking-[-0.25px] text-lum-espresso">Shop</a>
                    <a href="#" class="font-serif text-[56px] leading-[68px] tracking-[-0.25px] text-lum-espresso">Contacts</a>
                    <a href="#" class="font-serif text-[56px] leading-[68px] tracking-[-0.25px] text-lum-espresso">Blog</a>
                </nav>

                <div class="absolute right-[72px] top-[168px] h-[528px] w-[703px] overflow-hidden bg-lum-green" data-lum-menu-reveal="4">
                    <img src="{{ asset('images/lum/menu/map.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-black/32"></div>
                    <div class="absolute bottom-[40px] left-[44px] font-serif text-[32px] font-medium leading-[36px] tracking-[0.32px] text-lum-ivory">
                        Thiththagalla road,<br>Ahangama, Sri Lanka
                    </div>
                    <a href="#" class="lum-btn-ivory absolute bottom-[44px] right-[44px]">SEE on map</a>
                </div>
            </div>
        </div>

                @include('lum.partials.burger-menu-footer')
            </div>
        </div>

        <button
            type="button"
            class="lum-burger-menu__hitarea block min-h-0 w-full shrink-0 flex-1 border-0 bg-transparent p-0"
            data-lum-menu-backdrop
            aria-label="Close menu"
        ></button>
    </div>
</div>
