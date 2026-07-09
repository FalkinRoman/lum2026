@php
    $headerTone = $headerTone ?? 'ivory';
    $isEspresso = $headerTone === 'espresso';
    $homeHero = $homeHero ?? false;
@endphp
<header @class([
    'absolute left-[20px] top-0 z-50 h-[80px] w-[335px] border-b',
    'border-lum-ivory-40' => ! $isEspresso,
    'border-lum-espresso/16' => $isEspresso,
])>
    <a href="/" class="absolute left-0 top-1/2 h-[32px] w-[84px] -translate-y-1/2">
        <img src="{{ asset($isEspresso ? 'images/lum/menu/logo-lum-espresso.svg' : 'images/lum/hero/logo-lum-cream.svg') }}" alt="Lum" class="h-full w-full object-contain object-left" width="84" height="32">
    </a>

    <button type="button" @class([
        'lum-burger-btn absolute right-0 top-1/2 flex -translate-y-1/2 items-center',
        'lum-burger-btn--espresso-compact' => $isEspresso,
        'lum-burger-btn--ivory-compact' => ! $isEspresso,
        'lum-burger-btn--on-home-hero' => $homeHero && ! $isEspresso,
    ]) aria-label="{{ __('lum.aria.menu') }}" data-lum-menu-toggle aria-controls="lum-burger-menu" aria-expanded="false">
        <img src="{{ asset('images/lum/hero/burger.svg') }}" alt="" class="size-[32px]" width="32" height="32">
    </button>

    <a href="#" @class([
        'absolute right-[82px] top-1/2 -translate-y-1/2 px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]',
        'lum-btn-outline-ivory' => ! $isEspresso,
        'lum-btn-outline' => $isEspresso,
    ])>{{ __('lum.nav.break') }}</a>
</header>
