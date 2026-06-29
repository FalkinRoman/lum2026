<footer class="lum-container relative h-[780px] bg-lum-espresso mix-blend-multiply tab:h-[1089px] desk:h-[800px]">
    <img src="{{ $img('footer/bg.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover" width="1920" height="800">

    {{-- MOBILE --}}
    <div class="relative h-full tab:hidden">
        <div class="absolute left-[20px] top-[44px] lum-text-2">
            <p class="font-medium text-lum-ivory">Contact</p>
            <p class="text-lum-ivory-40">Reception</p>
        </div>
        <div class="absolute left-[20px] top-[100px] w-[335px]">
            <p class="font-serif text-[42px] leading-[45px] text-lum-ivory">
                @include('lum.partials.link-3d-text', [
                    'href' => 'tel:+94779296087',
                    'text' => '+94 (779) 296-087',
                ])
            </p>
            <p class="mt-[24px] font-serif text-[24px] leading-[28px] tracking-[0.24px] text-lum-ivory">
                @include('lum.partials.link-3d-text', [
                    'href' => 'mailto:dimacake@gmail.com',
                    'text' => 'dimacake@gmail.com',
                ])
            </p>
        </div>
        <img src="{{ $img('footer/logomark.svg') }}" alt="" class="absolute left-1/2 top-[280px] size-[160px] -translate-x-1/2" width="160" height="160">
        <div class="absolute left-[20px] top-[500px] flex items-center gap-[12px]">
            <div class="flex items-center gap-[2px]">
                @for ($i = 0; $i < 4; $i++)<img src="{{ $img('footer/star-full.svg') }}" alt="" class="size-[18px]" width="18" height="18">@endfor
                <img src="{{ $img('footer/star-half.svg') }}" alt="" class="size-[18px]" width="18" height="18">
            </div>
            <p class="lum-text-3 font-medium text-lum-ivory">4.9 <span class="text-lum-ivory-40">/ 139 reviews</span></p>
        </div>
        <div class="absolute left-[20px] top-[560px] text-[20px] leading-[24px] text-lum-ivory">
            <p>Thiththagalla road, Walhengoda,</p>
            <p>Ахангама 80650 Шри-Ланка</p>
        </div>
        <div class="absolute left-[20px] top-[640px] flex items-center gap-[10px]">
            <a href="#" class="lum-btn-ivory px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">SEE on map</a>
            @for ($i = 0; $i < 2; $i++)
                <a href="#" class="flex items-center rounded-[50px] border border-lum-ivory p-[2px]" aria-label="Social"><img src="{{ $img('footer/instagram.svg') }}" alt="" class="size-[32px]" width="32" height="32"></a>
            @endfor
        </div>
        <button type="button" data-lum-back-to-top class="absolute right-[20px] bottom-[120px] flex size-[40px] -scale-y-100 items-center justify-center rounded-full bg-lum-ivory p-[4px]" aria-label="Back to top">
            <img src="{{ $img('footer/arrow-up.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
        <div class="lum-divider absolute bottom-[88px] left-[20px] bg-lum-ivory-40 opacity-100"></div>
        <div class="absolute bottom-[56px] left-[20px] lum-text-2 text-lum-ivory-40">©Lum — 2026 all rights Reserved</div>
        <div class="absolute bottom-[32px] left-[20px] flex items-start gap-[24px] lum-text-2">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => 'Privacy Policy', 'classes' => 'lum-link--footer-legal'])
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => 'Terms of Use', 'classes' => 'lum-link--footer-legal'])
        </div>
    </div>

    {{-- TABLET --}}
    <div class="relative hidden h-full tab:block desk:hidden">
        <div class="absolute left-[20px] top-[60px] lum-text-2">
            <p class="font-medium text-lum-ivory">Contact</p>
            <p class="text-lum-ivory-40">Reception</p>
        </div>
        <div class="absolute left-[20px] top-[120px] w-[335px]">
            <p class="whitespace-nowrap font-serif text-[52px] leading-[52px] text-lum-ivory">
                @include('lum.partials.link-3d-text', [
                    'href' => 'tel:+94779296087',
                    'text' => '+94 (779) 296-087',
                ])
            </p>
            <p class="mt-[32px] font-serif text-[28px] leading-[32px] tracking-[0.28px] text-lum-ivory">
                @include('lum.partials.link-3d-text', [
                    'href' => 'mailto:dimacake@gmail.com',
                    'text' => 'dimacake@gmail.com',
                ])
            </p>
        </div>
        <img src="{{ $img('footer/logomark.svg') }}" alt="" class="absolute left-1/2 top-[400px] size-[200px] -translate-x-1/2" width="200" height="200">
        <div class="absolute left-[20px] top-[700px] flex items-center gap-[12px]">
            <div class="flex items-center gap-[2px]">
                @for ($i = 0; $i < 4; $i++)<img src="{{ $img('footer/star-full.svg') }}" alt="" class="size-[18px]" width="18" height="18">@endfor
                <img src="{{ $img('footer/star-half.svg') }}" alt="" class="size-[18px]" width="18" height="18">
            </div>
            <p class="lum-text-3 font-medium text-lum-ivory">4.9 <span class="text-lum-ivory-40">/ 139 reviews</span></p>
        </div>
        <div class="absolute left-[20px] top-[760px] text-[24px] leading-[28px] text-lum-ivory">
            <p>Thiththagalla road, Walhengoda,</p>
            <p>Ахангама 80650 Шри-Ланка</p>
        </div>
        <div class="absolute left-[20px] top-[840px] flex items-center gap-[10px]">
            <a href="#" class="lum-btn-ivory px-[24px] pt-[5px] pb-[4px] text-[14px] leading-[23px] tracking-[2.84px]">SEE on map</a>
            @for ($i = 0; $i < 2; $i++)
                <a href="#" class="flex items-center rounded-[50px] border border-lum-ivory p-[2px]" aria-label="Social"><img src="{{ $img('footer/instagram.svg') }}" alt="" class="size-[32px]" width="32" height="32"></a>
            @endfor
        </div>
        <button type="button" data-lum-back-to-top class="absolute right-[20px] bottom-[140px] flex size-[40px] -scale-y-100 items-center justify-center rounded-full bg-lum-ivory p-[4px]" aria-label="Back to top">
            <img src="{{ $img('footer/arrow-up.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
        <div class="lum-divider absolute bottom-[88px] left-[20px] bg-lum-ivory-40 opacity-100"></div>
        <div class="absolute bottom-[56px] left-[20px] lum-text-2 text-lum-ivory-40">©Lum — 2026 all rights Reserved</div>
        <div class="absolute bottom-[32px] left-1/2 flex -translate-x-1/2 items-start gap-[40px] lum-text-2">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => 'Privacy Policy', 'classes' => 'lum-link--footer-legal'])
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => 'Terms of Use', 'classes' => 'lum-link--footer-legal'])
        </div>
    </div>

    {{-- DESKTOP (не трогаем) --}}
    <div class="relative hidden h-full desk:block">
        <div class="absolute left-[72px] top-[80px] lum-text-2">
            <p class="font-medium text-lum-ivory">Contact</p>
            <p class="text-lum-ivory-40">Reception</p>
        </div>
        <div class="absolute right-[72px] top-[72px] text-right">
            <p class="lum-heading-1 text-lum-ivory">
                @include('lum.partials.link-3d-text', [
                    'href' => 'tel:+94779296087',
                    'text' => '+94 (779) 296-087',
                ])
            </p>
            <p class="lum-heading-3 mt-[44px] text-lum-ivory">
                @include('lum.partials.link-3d-text', [
                    'href' => 'mailto:dimacake@gmail.com',
                    'text' => 'dimacake@gmail.com',
                ])
            </p>
        </div>
        <img src="{{ $img('footer/logomark.svg') }}" alt="" class="absolute left-1/2 top-1/2 size-[240px] -translate-x-1/2 -translate-y-1/2" width="240" height="240">
        <div class="absolute left-[72px] top-[491px] flex items-center gap-[12px]">
            <div class="flex items-center gap-[2px]">
                @for ($i = 0; $i < 4; $i++)<img src="{{ $img('footer/star-full.svg') }}" alt="" class="size-[18px]" width="18" height="18">@endfor
                <img src="{{ $img('footer/star-half.svg') }}" alt="" class="size-[18px]" width="18" height="18">
            </div>
            <p class="lum-text-3 font-medium text-lum-ivory">4.9 <span class="text-lum-ivory-40">/ 139 reviews</span></p>
        </div>
        <div class="absolute left-[72px] top-[553px] lum-heading-3 text-lum-ivory">
            <p>Thiththagalla road, Walhengoda,</p>
            <p>Ахангама 80650 Шри-Ланка</p>
        </div>
        <div class="absolute left-[72px] top-[635px] flex items-center gap-[10px]">
            <a href="#" class="lum-btn-ivory">SEE on map</a>
            @for ($i = 0; $i < 2; $i++)
                <a href="#" class="flex items-center rounded-[50px] border border-lum-ivory p-[2px]" aria-label="Social"><img src="{{ $img('footer/instagram.svg') }}" alt="" class="size-[32px]" width="32" height="32"></a>
            @endfor
        </div>
        <nav class="absolute right-[72px] top-[615px] flex gap-[40px] lum-text-2 font-medium text-lum-ivory">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => 'Lum Residence'])
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => 'Oculus'])
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => 'Lum Ocean'])
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => 'Lum Villas'])
        </nav>
        <button type="button" data-lum-back-to-top class="absolute right-[72px] bottom-[93px] flex size-[40px] -scale-y-100 items-center justify-center rounded-full bg-lum-ivory p-[4px]" aria-label="Back to top">
            <img src="{{ $img('footer/arrow-up.svg') }}" alt="" class="size-[32px]" width="32" height="32">
        </button>
        <div class="lum-divider absolute bottom-[64px] left-[72px] bg-lum-ivory-40 opacity-100"></div>
        <div class="absolute bottom-[32px] left-[72px] lum-text-2 text-lum-ivory-40">©Lum — 2026 all rights Reserved</div>
        <div class="absolute bottom-[32px] left-1/2 flex -translate-x-1/2 items-start gap-[40px] lum-text-2">
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => 'Privacy Policy', 'classes' => 'lum-link--footer-legal'])
            @include('lum.partials.link-footer-nav', ['img' => $img, 'label' => 'Terms of Use', 'classes' => 'lum-link--footer-legal'])
        </div>
        <div class="absolute right-[72px] bottom-[32px] text-right lum-text-2 text-lum-ivory-40">
            <span>Des & Dev / </span>
            @include('lum.partials.link-footer-nav', [
                'img' => $img,
                'href' => 'https://t.me/ivantaskayev',
                'label' => 'Ivan Taskayev',
                'classes' => 'lum-link--footer-legal',
                'target' => '_blank',
                'rel' => 'noopener noreferrer',
            ])
            <span> & </span>
            @include('lum.partials.link-footer-nav', [
                'img' => $img,
                'href' => 'https://t.me/falroman',
                'label' => 'Roman Falkin',
                'classes' => 'lum-link--footer-legal',
                'target' => '_blank',
                'rel' => 'noopener noreferrer',
            ])
        </div>
    </div>
</footer>
