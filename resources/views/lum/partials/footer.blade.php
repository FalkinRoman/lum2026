<footer class="lum-container relative h-[780px] bg-lum-espresso mix-blend-multiply tab:h-[1089px] desk:h-[800px]">
@php
    $villaUrl = fn (string $slug) => route('villa.show', $slug);
@endphp
    <img src="{{ $img('footer/bg.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover" width="1920" height="800">

    {{-- MOBILE — 375×780 --}}
    <div class="relative h-full tab:hidden">
        <div class="absolute left-1/2 top-[38px] w-[72px] -translate-x-1/2 text-center lum-text-3">
            <p class="font-medium text-lum-ivory">{{ __('lum.footer.contact') }}</p>
            <p class="text-lum-ivory-40">{{ __('lum.footer.reception') }}</p>
        </div>

        <div class="absolute left-[20px] top-[102px] flex w-[335px] flex-col items-center gap-[16px] text-center text-lum-ivory">
            <p class="w-full font-serif text-[42px] leading-[45px]">
                @include('lum.partials.link-3d-text', [
                    'href' => 'tel:+94779296087',
                    'text' => '+94 (779) 296-087',
                ])
            </p>
            <p class="w-full font-serif text-[22px] font-medium leading-[24px] tracking-[0.194px]">
                @include('lum.partials.link-3d-text', [
                    'href' => 'mailto:dimacake@gmail.com',
                    'text' => 'dimacake@gmail.com',
                ])
            </p>
        </div>

        <img src="{{ $img('footer/logomark.svg') }}" alt="" class="absolute left-[155px] top-[221px] size-[64px]" width="64" height="64">

        <div class="absolute left-[20px] top-[336px] -translate-y-1/2 lum-text-3 font-medium text-lum-ivory">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.nav.lum_residence'), 'href' => $villaUrl('residence'), 'variant' => 'line'])
        </div>
        <div class="absolute left-[160px] top-[336px] -translate-y-1/2 lum-text-3 font-medium text-lum-ivory">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.nav.lum_villas'), 'href' => $villaUrl('villas'), 'variant' => 'line'])
        </div>
        <div class="absolute left-[20px] top-[366px] -translate-y-1/2 lum-text-3 font-medium text-lum-ivory">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.nav.oculus'), 'href' => $villaUrl('oculus'), 'variant' => 'line'])
        </div>
        <div class="absolute left-[160px] top-[366px] -translate-y-1/2 lum-text-3 font-medium text-lum-ivory">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.nav.lum_ocean'), 'href' => $villaUrl('ocean'), 'variant' => 'line'])
        </div>

        <div class="absolute top-[406px] left-1/2 h-px w-[335px] -translate-x-1/2 bg-lum-ivory-40 opacity-16"></div>

        <div class="absolute left-[20px] top-[437px] flex items-center gap-[12px]">
            <div class="flex items-center gap-[2px]">
                @for ($i = 0; $i < 4; $i++)
                    <img src="{{ $img('footer/star-full.svg') }}" alt="" class="size-[16px]" width="16" height="16">
                @endfor
                <img src="{{ $img('footer/star-half.svg') }}" alt="" class="size-[16px]" width="16" height="16">
            </div>
            <p class="flex items-center gap-[4px] text-[12px] font-medium leading-[12px] tracking-[0.6px] text-lum-ivory">
                4.9
                <span class="text-lum-ivory-40">/</span>
                <span class="text-lum-ivory-40">{{ __('lum.footer.reviews') }}</span>
            </p>
        </div>

        <div class="absolute left-[20px] top-[546px] -translate-y-full font-serif text-[22px] font-medium leading-[24px] tracking-[0.194px] text-lum-ivory">
            <p>{{ __('lum.footer.address_line1') }}</p>
            <p>{{ __('lum.footer.address_line2') }}</p>
            <p>{{ __('lum.footer.address_line3') }}</p>
        </div>

        <div class="absolute left-[20px] top-[562px]">
            <a href="#" class="lum-btn-ivory px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.location.see_on_map_upper') }}</a>
        </div>
        <div class="absolute left-[281px] top-[562px] flex items-center gap-[10px]">
            @include('lum.partials.footer-social', ['img' => $img, 'network' => 'instagram'])
            @include('lum.partials.footer-social', ['img' => $img, 'network' => 'whatsapp'])
        </div>

        <p class="absolute left-[20px] top-[655px] -translate-y-1/2 text-[14px] leading-[22px] tracking-[0.1px] font-normal text-lum-ivory-40 whitespace-nowrap">{{ __('lum.footer.copyright') }}</p>

        <div class="lum-footer-legal absolute left-[calc(50%-68px)] top-[678px] -translate-x-1/2 gap-[40px] text-[14px] leading-[22px] tracking-[0.1px] font-normal text-lum-ivory-40 whitespace-nowrap">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.footer.privacy'), 'classes' => 'lum-link--footer-legal'])
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.footer.terms'), 'classes' => 'lum-link--footer-legal'])
        </div>

        <button type="button" data-lum-back-to-top class="absolute left-[315px] top-[708px] lum-icon-btn lum-icon-btn--ivory-filled lum-icon-btn--round p-[4px]" aria-label="{{ __('lum.aria.back_to_top') }}">
            <img src="{{ $img('footer/arrow-up.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>

        @include('lum.partials.footer-credits', [
            'img' => $img,
            'creditsClass' => 'lum-footer-credits--mobile',
            'wrapperClass' => 'absolute left-[276px] top-[737px] -translate-x-full -translate-y-1/2 text-right text-[14px] leading-[22px] tracking-[0.1px] font-normal text-lum-ivory',
        ])
    </div>

    {{-- TABLET — 960×1089 --}}
    <div class="relative hidden h-full tab:block desk:hidden">
        <div class="absolute left-1/2 top-[64px] w-[72px] -translate-x-1/2 text-center lum-text-2">
            <p class="font-medium text-lum-ivory">{{ __('lum.footer.contact') }}</p>
            <p class="text-lum-ivory-40">{{ __('lum.footer.reception') }}</p>
        </div>

        <p class="absolute right-[278px] top-[200px] -translate-y-1/2 whitespace-nowrap text-right font-serif text-[52px] leading-[52px] text-lum-ivory">
            @include('lum.partials.link-3d-text', [
                'href' => 'tel:+94779296087',
                'text' => '+94 (779) 296-087',
            ])
        </p>
        <p class="absolute right-[336px] top-[267px] -translate-y-1/2 whitespace-nowrap text-right font-serif text-[28px] font-medium leading-[34px] tracking-[0.364px] text-lum-ivory">
            @include('lum.partials.link-3d-text', [
                'href' => 'mailto:dimacake@gmail.com',
                'text' => 'dimacake@gmail.com',
            ])
        </p>

        <img src="{{ $img('footer/logomark.svg') }}" alt="" class="absolute left-[400px] top-[364px] size-[160px]" width="160" height="160">

        <div class="absolute left-[22px] top-[616.5px] -translate-y-1/2 lum-text-2 font-medium text-lum-ivory">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.nav.lum_residence'), 'href' => $villaUrl('residence'), 'variant' => 'line'])
        </div>
        <div class="absolute left-[250px] top-[616.5px] -translate-y-1/2 lum-text-2 font-medium text-lum-ivory">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.nav.lum_villas'), 'href' => $villaUrl('villas'), 'variant' => 'line'])
        </div>
        <div class="absolute left-[22px] top-[646.5px] -translate-y-1/2 lum-text-2 font-medium text-lum-ivory">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.nav.oculus'), 'href' => $villaUrl('oculus'), 'variant' => 'line'])
        </div>
        <div class="absolute left-[250px] top-[646.5px] -translate-y-1/2 lum-text-2 font-medium text-lum-ivory">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.nav.lum_ocean'), 'href' => $villaUrl('ocean'), 'variant' => 'line'])
        </div>

        <div class="absolute top-[691px] left-[22px] h-px w-[920px] bg-lum-ivory-40 opacity-16"></div>

        <div class="absolute left-[22px] top-[724px] flex items-center gap-[12px]">
            <div class="flex items-center gap-[2px]">
                @for ($i = 0; $i < 4; $i++)
                    <img src="{{ $img('footer/star-full.svg') }}" alt="" class="size-[18px]" width="18" height="18">
                @endfor
                <img src="{{ $img('footer/star-half.svg') }}" alt="" class="size-[18px]" width="18" height="18">
            </div>
            <p class="flex items-center gap-[4px] lum-text-3 font-medium text-lum-ivory">
                4.9
                <span class="text-lum-ivory-40">/</span>
                <span class="text-lum-ivory-40">{{ __('lum.footer.reviews') }}</span>
            </p>
        </div>

        <div class="absolute left-[22px] top-[864px] -translate-y-full font-serif text-[28px] font-medium leading-[34px] tracking-[0.364px] text-lum-ivory">
            <p>{{ __('lum.footer.address_tablet') }}</p>
            <p>{{ __('lum.footer.address_tablet_2') }}</p>
        </div>

        <div class="absolute left-[22px] top-[883px]">
            <a href="#" class="lum-btn-ivory px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">{{ __('lum.location.see_on_map_upper') }}</a>
        </div>
        <div class="absolute left-[866px] top-[883px] flex items-center gap-[10px]">
            @include('lum.partials.footer-social', ['img' => $img, 'network' => 'instagram'])
            @include('lum.partials.footer-social', ['img' => $img, 'network' => 'whatsapp'])
        </div>

        <p class="absolute left-[22px] top-[991.5px] -translate-y-1/2 lum-text-2 font-normal text-lum-ivory-40 whitespace-nowrap">{{ __('lum.footer.copyright') }}</p>

        <div class="lum-footer-legal absolute left-[20px] top-[1024px] gap-[40px] lum-text-2 font-normal text-lum-ivory-40 whitespace-nowrap">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.footer.privacy'), 'classes' => 'lum-link--footer-legal'])
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.footer.terms'), 'classes' => 'lum-link--footer-legal'])
        </div>

        @include('lum.partials.footer-credits', [
            'img' => $img,
            'creditsClass' => 'lum-footer-credits--tablet',
            'wrapperClass' => 'absolute left-[785px] top-[1036.5px] -translate-x-full -translate-y-1/2 text-right lum-text-2 font-normal text-lum-ivory',
        ])

        <button type="button" data-lum-back-to-top class="absolute left-[884px] top-[993px] lum-icon-btn lum-icon-btn--ivory-filled lum-icon-btn--round p-[12px]" aria-label="{{ __('lum.aria.back_to_top') }}">
            <img src="{{ $img('footer/arrow-up.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
    </div>

    {{-- DESKTOP — 1920×800 --}}
    <div class="relative hidden h-full desk:block">
        <div class="absolute left-[72px] top-[80px] lum-text-2">
            <p class="font-medium text-lum-ivory">{{ __('lum.footer.contact') }}</p>
            <p class="text-lum-ivory-40">{{ __('lum.footer.reception') }}</p>
        </div>

        <div class="absolute right-[72px] top-[72px] text-right text-lum-ivory">
            <p class="lum-heading-1">
                @include('lum.partials.link-3d-text', [
                    'href' => 'tel:+94779296087',
                    'text' => '+94 (779) 296-087',
                ])
            </p>
            <p class="lum-heading-3 mt-[44px]">
                @include('lum.partials.link-3d-text', [
                    'href' => 'mailto:dimacake@gmail.com',
                    'text' => 'dimacake@gmail.com',
                ])
            </p>
        </div>

        <img src="{{ $img('footer/logomark.svg') }}" alt="" class="absolute left-1/2 top-1/2 size-[240px] -translate-x-1/2 -translate-y-1/2" width="240" height="240">

        <div class="absolute left-[72px] top-[491px] flex items-center gap-[12px]">
            <div class="flex items-center gap-[2px]">
                @for ($i = 0; $i < 4; $i++)
                    <img src="{{ $img('footer/star-full.svg') }}" alt="" class="size-[18px]" width="18" height="18">
                @endfor
                <img src="{{ $img('footer/star-half.svg') }}" alt="" class="size-[18px]" width="18" height="18">
            </div>
            <p class="flex items-center gap-[4px] lum-text-3 font-medium text-lum-ivory">
                4.9
                <span class="text-lum-ivory-40">/</span>
                <span class="text-lum-ivory-40">{{ __('lum.footer.reviews') }}</span>
            </p>
        </div>

        <div class="absolute left-[72px] top-[615px] -translate-y-full lum-heading-3 text-lum-ivory">
            <p>{{ __('lum.footer.address_tablet') }}</p>
            <p>{{ __('lum.footer.address_tablet_2') }}</p>
        </div>

        <div class="absolute left-[72px] top-[635px] flex items-center gap-[10px]">
            <a href="#" class="lum-btn-ivory">{{ __('lum.location.see_on_map_upper') }}</a>
            @include('lum.partials.footer-social', ['img' => $img, 'network' => 'instagram'])
            @include('lum.partials.footer-social', ['img' => $img, 'network' => 'whatsapp'])
        </div>

        <nav class="absolute left-[1415px] top-[615px] flex gap-[40px] lum-text-2 font-medium text-lum-ivory">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.nav.lum_residence'), 'href' => $villaUrl('residence'), 'variant' => 'line'])
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.nav.oculus'), 'href' => $villaUrl('oculus'), 'variant' => 'line'])
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.nav.lum_ocean'), 'href' => $villaUrl('ocean'), 'variant' => 'line'])
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.nav.lum_villas'), 'href' => $villaUrl('villas'), 'variant' => 'line'])
        </nav>

        <button type="button" data-lum-back-to-top class="absolute right-[72px] top-[667px] lum-icon-btn lum-icon-btn--ivory-filled lum-icon-btn--round size-[40px] p-[4px]" aria-label="{{ __('lum.aria.back_to_top') }}">
            <img src="{{ $img('footer/arrow-up.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>

        <div class="absolute bottom-[64px] left-1/2 h-px w-[1776px] -translate-x-1/2 bg-lum-ivory-40 opacity-16"></div>

        <p class="absolute left-[72px] top-[768.5px] -translate-y-1/2 lum-text-2 font-normal text-lum-ivory-40 whitespace-nowrap">{{ __('lum.footer.copyright') }}</p>

        <div class="lum-footer-legal absolute left-1/2 top-[756px] -translate-x-1/2 gap-[40px] lum-text-2 font-normal text-lum-ivory-40 whitespace-nowrap">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.footer.privacy'), 'classes' => 'lum-link--footer-legal'])
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => __('lum.footer.terms'), 'classes' => 'lum-link--footer-legal'])
        </div>

        @include('lum.partials.footer-credits', [
            'img' => $img,
            'creditsClass' => 'lum-footer-credits--desktop',
            'wrapperClass' => 'absolute left-[1846px] top-[767.5px] -translate-x-full -translate-y-1/2 text-right lum-text-2 font-normal text-lum-ivory',
        ])
    </div>
</footer>
