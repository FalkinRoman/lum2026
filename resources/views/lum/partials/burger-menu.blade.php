@php
    $locale = app()->getLocale();
    $villaUrl = fn (string $slug) => route('villa.show', $slug);
    $villaSlug = request()->routeIs('villa.show') ? (string) request()->route('slug') : null;
    $menuActive = [
        'home' => request()->routeIs('home'),
        'stay' => request()->routeIs('stay'),
        'dining' => request()->routeIs('dining', 'restaurant.show'),
        'relax' => request()->routeIs('relax'),
        'discover' => request()->routeIs('discover', 'discover.show'),
        'shop' => request()->routeIs('shop'),
        'contacts' => request()->routeIs('contacts'),
        'blog' => request()->routeIs('blog', 'blog.show'),
        'residence' => $villaSlug === 'residence',
        'oculus' => $villaSlug === 'oculus',
        'ocean' => $villaSlug === 'ocean',
        'villas' => $villaSlug === 'villas',
    ];
@endphp
<div
    id="lum-burger-menu"
    class="lum-burger-menu fixed inset-0 z-[5000] hidden"
    hidden
    aria-hidden="true"
    role="dialog"
    aria-modal="true"
    aria-label="{{ __('lum.aria.menu') }}"
>
    <div
        class="lum-burger-menu__backdrop pointer-events-none fixed inset-0 z-[1] bg-black/32 backdrop-blur-[8px]"
        aria-hidden="true"
    ></div>
    <div
        class="lum-burger-menu__scroll pointer-events-auto fixed inset-0 z-[2] flex min-h-full flex-col overflow-y-auto overscroll-contain"
        data-lenis-prevent
        data-lenis-prevent-touch
    >
        <div class="lum-burger-menu__drawer relative w-full shrink-0 overflow-hidden">
            <div class="lum-burger-menu__scaled flex flex-col origin-top-left">
                <div class="lum-burger-menu__panel relative bg-lum-ivory">
            {{-- MOBILE --}}
            @include('lum.partials.burger-menu-mobile')

            {{-- TABLET --}}
            <div class="relative hidden h-[979px] w-full tab:block desk:hidden">
                <header class="absolute left-[20px] top-0 z-50 h-[80px] w-[920px] border-b border-lum-espresso/16">
                    <a href="/" class="absolute left-0 top-1/2 h-[32px] w-[84px] -translate-y-1/2">
                        <img src="{{ asset('images/lum/menu/logo-lum-espresso.svg') }}" alt="Lum" class="h-full w-full object-contain object-left" width="84" height="32">
                    </a>
                    <div class="absolute right-0 top-[24px] flex items-center gap-[10px]">
                        <div class="relative z-[5100]">
                            <button
                                type="button"
                                class="lum-icon-btn lum-icon-btn--espresso-outline"
                                data-lum-lang-toggle
                                aria-label="{{ __('lum.aria.language') }}"
                                aria-expanded="false"
                                aria-controls="lum-lang-panel-burger-tab"
                            >
                                <img src="{{ asset('images/lum/hero/language.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                            </button>
                            @include('lum.partials.language-switcher', ['panelId' => 'lum-lang-panel-burger-tab'])
                        </div>
                        <a href="#" class="lum-btn-outline px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.nav.take_a_break') }}</a>
                        <a href="{{ route('contacts') }}" class="lum-icon-btn lum-icon-btn--espresso-filled" aria-label="{{ __('lum.aria.contact') }}">
                            <img src="{{ asset('images/lum/hero/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                        </a>
                        <button type="button" class="lum-burger-btn lum-burger-btn--espresso-compact flex items-center" data-lum-menu-close aria-label="{{ __('lum.aria.close_menu') }}">
                            <img src="{{ asset('images/lum/menu/close.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                        </button>
                    </div>
                </header>

                <nav class="absolute left-[20px] top-[144px] z-10 flex w-[920px] flex-col gap-[6px] font-serif text-[36px] leading-[36px] tracking-[-0.25px] text-lum-espresso" data-lum-menu-nav>
                    @include('lum.partials.burger-menu-link', ['href' => route('stay'), 'label' => __('lum.nav.stay'), 'active' => $menuActive['stay']])
                    @include('lum.partials.burger-menu-link', ['href' => route('dining'), 'label' => __('lum.nav.dining'), 'active' => $menuActive['dining']])
                    @include('lum.partials.burger-menu-link', ['href' => route('relax'), 'label' => __('lum.nav.relax'), 'active' => $menuActive['relax']])
                    @include('lum.partials.burger-menu-link', ['href' => route('discover'), 'label' => __('lum.nav.discover'), 'active' => $menuActive['discover']])
                    <div class="flex flex-wrap items-center gap-[12px]">
                        @include('lum.partials.burger-menu-link', ['href' => route('shop'), 'label' => __('lum.nav.shop'), 'active' => $menuActive['shop']])
                        <span class="text-lum-espresso/16">/</span>
                        @include('lum.partials.burger-menu-link', ['href' => route('contacts'), 'label' => __('lum.nav.contacts'), 'active' => $menuActive['contacts']])
                        <span class="text-lum-espresso/16">/</span>
                        @include('lum.partials.burger-menu-link', ['href' => route('blog'), 'label' => __('lum.nav.blog'), 'active' => $menuActive['blog']])
                    </div>
                </nav>

                <div class="absolute left-[20px] top-[372px] h-px w-[920px] bg-lum-espresso/16" data-lum-menu-reveal="3"></div>

                <p class="absolute left-[20px] top-[403px] text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-espresso-40" data-lum-menu-reveal="3">{{ __('lum.nav.projects') }}</p>

                <div class="absolute left-[20px] top-[436px] grid w-[920px] grid-cols-2 gap-y-[12px] text-[14px] font-medium leading-[14px] tracking-[0.6px] text-lum-espresso" data-lum-menu-reveal="3">
                    <a href="{{ $villaUrl('residence') }}" @class(['inline-flex items-center gap-[6px]', 'is-active' => $menuActive['residence']])>
                        {{ __('lum.nav.lum_residence') }}
                        @if ($menuActive['residence'])<span class="lum-menu-dot" data-lum-menu-dot aria-hidden="true"></span>@endif
                    </a>
                    <a href="{{ $villaUrl('villas') }}" @class(['inline-flex items-center gap-[6px]', 'is-active' => $menuActive['villas']])>
                        {{ __('lum.nav.lum_villas') }}
                        @if ($menuActive['villas'])<span class="lum-menu-dot" data-lum-menu-dot aria-hidden="true"></span>@endif
                    </a>
                    <a href="{{ $villaUrl('oculus') }}" @class(['inline-flex items-center gap-[6px]', 'is-active' => $menuActive['oculus']])>
                        {{ __('lum.nav.oculus') }}
                        @if ($menuActive['oculus'])<span class="lum-menu-dot" data-lum-menu-dot aria-hidden="true"></span>@endif
                    </a>
                    <a href="{{ $villaUrl('ocean') }}" @class(['inline-flex items-center gap-[6px]', 'is-active' => $menuActive['ocean']])>
                        {{ __('lum.nav.lum_ocean') }}
                        @if ($menuActive['ocean'])<span class="lum-menu-dot" data-lum-menu-dot aria-hidden="true"></span>@endif
                    </a>
                </div>

                <div class="absolute left-[20px] top-[499px] z-10 h-[480px] w-[920px] overflow-hidden bg-lum-green" data-lum-menu-reveal="4">
                    <img src="{{ asset('images/lum/menu/map.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-black/32"></div>
                    <div class="absolute bottom-[31px] left-[36px] font-serif text-[28px] font-medium leading-[34px] tracking-[0.36px] text-lum-ivory">
                        {!! __('lum.footer.address_menu') !!}
                    </div>
                    <a href="#" class="lum-btn-ivory absolute bottom-[36px] right-[36px] px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.location.see_on_map_upper') }}</a>
                </div>
            </div>

            {{-- DESKTOP --}}
            <div class="relative hidden h-[732px] w-full desk:block">
                <header class="absolute left-1/2 top-0 z-50 h-[132px] w-[1776px] -translate-x-1/2 border-b border-lum-espresso/16">
                    <button type="button" class="lum-burger-btn lum-burger-btn--espresso absolute left-0 top-1/2 flex -translate-y-1/2 items-center" data-lum-menu-close aria-label="{{ __('lum.aria.close_menu') }}">
                        <img src="{{ asset('images/lum/menu/close.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                    </button>
                    <div class="absolute left-[112px] top-1/2 h-[18px] w-px -translate-y-1/2 bg-lum-espresso/16"></div>
                    <nav class="lum-nav absolute left-[153px] top-[54px] flex items-start gap-[40px] overflow-visible text-[16px] font-medium leading-[25px] tracking-[0.16px] text-lum-espresso">
                        @include('lum.partials.nav-link', ['href' => route('stay'), 'label' => __('lum.nav.stay'), 'active' => $menuActive['stay'] || $villaSlug !== null])
                        @include('lum.partials.nav-link', ['href' => route('dining'), 'label' => __('lum.nav.dining'), 'active' => $menuActive['dining']])
                        @include('lum.partials.nav-link', ['href' => route('relax'), 'label' => __('lum.nav.relax'), 'active' => $menuActive['relax']])
                        @include('lum.partials.nav-link', [
                            'href' => route('discover'),
                            'label' => __('lum.nav.discover'),
                            'active' => $menuActive['discover'],
                        ])
                    </nav>
                    <a href="/" class="absolute left-1/2 top-1/2 h-[40px] w-[105px] -translate-x-1/2 -translate-y-1/2">
                        <img src="{{ asset('images/lum/menu/logo-lum-espresso.svg') }}" alt="Lum" class="h-[40px] w-[105px]" width="105" height="40">
                    </a>
                    <div class="absolute right-0 top-[48px] flex items-center gap-[10px]">
                        <div class="relative z-[5100]">
                            <button
                                type="button"
                                class="lum-icon-btn lum-icon-btn--espresso-outline"
                                data-lum-lang-toggle
                                aria-label="{{ __('lum.aria.language') }}"
                                aria-expanded="false"
                                aria-controls="lum-lang-panel-burger-desk"
                            >
                                <img src="{{ asset('images/lum/hero/language.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                            </button>
                            @include('lum.partials.language-switcher', ['panelId' => 'lum-lang-panel-burger-desk'])
                        </div>
                        <a href="#" class="lum-btn-outline">{{ __('lum.nav.take_a_break') }}</a>
                        <a href="{{ route('contacts') }}" class="lum-icon-btn lum-icon-btn--espresso-filled" aria-label="{{ __('lum.aria.contact') }}">
                            <img src="{{ asset('images/lum/hero/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
                        </a>
                    </div>
                </header>

                <nav class="absolute left-[72px] top-[320px] z-10 flex flex-col font-serif text-[56px] leading-[68px] tracking-[-0.25px] text-lum-espresso" data-lum-menu-nav>
                    @include('lum.partials.burger-menu-link', ['href' => route('home'), 'label' => __('lum.nav.home'), 'active' => $menuActive['home']])
                    <div class="flex flex-wrap items-center gap-[16px]">
                        @include('lum.partials.burger-menu-link', ['href' => $villaUrl('residence'), 'label' => __('lum.nav.residence', [], 'en'), 'active' => $menuActive['residence']])
                        <span class="text-lum-espresso/16">/</span>
                        @include('lum.partials.burger-menu-link', ['href' => $villaUrl('oculus'), 'label' => __('lum.nav.oculus', [], 'en'), 'active' => $menuActive['oculus']])
                        <span class="text-lum-espresso/16">/</span>
                        @include('lum.partials.burger-menu-link', ['href' => $villaUrl('ocean'), 'label' => __('lum.nav.ocean', [], 'en'), 'active' => $menuActive['ocean']])
                        <span class="text-lum-espresso/16">/</span>
                        @include('lum.partials.burger-menu-link', ['href' => $villaUrl('villas'), 'label' => __('lum.nav.villas', [], 'en'), 'active' => $menuActive['villas']])
                    </div>
                    @include('lum.partials.burger-menu-link', ['href' => route('shop'), 'label' => __('lum.nav.shop'), 'active' => $menuActive['shop']])
                    @include('lum.partials.burger-menu-link', ['href' => route('contacts'), 'label' => __('lum.nav.contacts'), 'active' => $menuActive['contacts']])
                    @include('lum.partials.burger-menu-link', ['href' => route('blog'), 'label' => __('lum.nav.blog'), 'active' => $menuActive['blog']])
                </nav>

                <div class="absolute right-[72px] top-[168px] z-10 h-[528px] w-[703px] overflow-hidden bg-lum-green" data-lum-menu-reveal="4">
                    <img src="{{ asset('images/lum/menu/map.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-black/32"></div>
                    <div class="absolute bottom-[40px] left-[44px] font-serif text-[32px] font-medium leading-[36px] tracking-[0.32px] text-lum-ivory">
                        {!! __('lum.footer.address_menu') !!}
                    </div>
                    <a href="#" class="lum-btn-ivory absolute bottom-[44px] right-[44px]">{{ __('lum.location.see_on_map_upper') }}</a>
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
            aria-label="{{ __('lum.aria.close_menu') }}"
        ></button>
    </div>
</div>
