@php
    $headerTone = $headerTone ?? 'ivory';
    $headerActive = $headerActive ?? null;
    $hideDiscoverDot = $hideDiscoverDot ?? request()->routeIs('discover.show');
    $isEspresso = $headerTone === 'espresso';
    $stayHref = route('stay');
@endphp
<header @class([
    'absolute left-[72px] top-0 z-50 h-[132px] w-[1776px] border-b',
    'border-lum-ivory-40' => ! $isEspresso,
    'border-lum-espresso/16' => $isEspresso,
])>
    <button type="button" @class([
        'lum-burger-btn absolute left-0 top-1/2 flex -translate-y-1/2 items-center',
        'lum-burger-btn--ivory' => ! $isEspresso,
        'lum-burger-btn--espresso' => $isEspresso,
    ]) aria-label="{{ __('lum.aria.menu') }}" data-lum-menu-toggle aria-controls="lum-burger-menu" aria-expanded="false">
        <img src="{{ asset('images/lum/hero/burger.svg') }}" alt="" class="size-[32px]" width="32" height="32">
    </button>

    <div @class([
        'absolute left-[112px] top-1/2 h-[18px] w-px -translate-y-1/2',
        'bg-lum-ivory-40' => ! $isEspresso,
        'bg-lum-espresso/16' => $isEspresso,
    ])></div>

    <nav @class([
        'absolute left-[153px] top-[54px] flex items-start gap-[40px] overflow-visible lum-text-2 font-medium',
        'text-lum-ivory' => ! $isEspresso,
        'text-lum-espresso' => $isEspresso,
    ])>
        <a href="{{ $stayHref }}" @class(['lum-nav-link--inline', 'is-active' => $headerActive === 'stay'])>
            <span>{{ __('lum.nav.stay') }}</span>
            <span class="lum-nav-link__dot" aria-hidden="true"></span>
        </a>
        <a href="{{ route('dining') }}" @class(['lum-nav-link--inline', 'is-active' => $headerActive === 'dining'])>
            <span>{{ __('lum.nav.dining') }}</span>
            <span class="lum-nav-link__dot" aria-hidden="true"></span>
        </a>
        <a href="{{ route('relax') }}" @class(['lum-nav-link--inline', 'is-active' => $headerActive === 'relax'])>
            <span>{{ __('lum.nav.relax') }}</span>
            <span class="lum-nav-link__dot" aria-hidden="true"></span>
        </a>
        <a href="{{ route('discover') }}" @class(['lum-nav-link--inline', 'is-active' => $headerActive === 'discover'])>
            <span>{{ __('lum.nav.discover') }}</span>
            @unless ($hideDiscoverDot && $headerActive === 'discover')
                <span class="lum-nav-link__dot" aria-hidden="true"></span>
            @endunless
        </a>
    </nav>

    <a href="/" class="absolute left-1/2 top-1/2 h-[40px] w-[105px] -translate-x-1/2 -translate-y-1/2">
        <img src="{{ asset($isEspresso ? 'images/lum/menu/logo-lum-espresso.svg' : 'images/lum/hero/logo-lum-cream.svg') }}" alt="Lum" class="h-[40px] w-[105px]" width="105" height="40">
    </a>

    <div class="absolute right-0 top-[48px] flex items-center gap-[10px]">
        <div class="relative z-[5100]">
            <button
                type="button"
                @class([
                    'lum-icon-btn',
                    'lum-icon-btn--ivory-outline' => ! $isEspresso,
                    'lum-icon-btn--espresso-outline' => $isEspresso,
                ])
                data-lum-lang-toggle
                aria-label="{{ __('lum.aria.language') }}"
                aria-expanded="false"
                aria-controls="lum-lang-panel-desktop"
            >
                <img src="{{ asset($isEspresso ? 'images/lum/hero/language.svg' : 'images/lum/hero/language-cream.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </button>
            @include('lum.partials.language-switcher', ['panelId' => 'lum-lang-panel-desktop'])
        </div>
        <a href="#" @class([
            'lum-btn-outline-ivory' => ! $isEspresso,
            'lum-btn-outline' => $isEspresso,
        ])>{{ __('lum.nav.take_a_break') }}</a>
        <a href="{{ route('contacts') }}" @class([
            'lum-icon-btn',
            'lum-icon-btn--ivory-filled' => ! $isEspresso,
            'lum-icon-btn--espresso-filled' => $isEspresso,
        ]) aria-label="{{ __('lum.aria.contact') }}">
            <img src="{{ asset('images/lum/hero/arrow.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </a>
    </div>
</header>
