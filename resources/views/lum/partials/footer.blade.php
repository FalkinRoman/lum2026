<footer class="lum-container relative h-[800px] bg-lum-espresso mix-blend-multiply">
    <img src="{{ $img('footer/bg.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover" width="1920" height="800">

    <div class="absolute left-[72px] top-[80px] lum-text-2">
        <p class="font-medium text-lum-ivory">Contact</p>
        <p class="text-lum-ivory-40">Reception</p>
    </div>

    <div class="absolute right-[72px] top-[72px] text-right">
        <p class="lum-heading-1 text-lum-ivory">+94 (779) 296-087</p>
        <p class="lum-heading-3 mt-[44px] text-lum-ivory">dimacake@gmail.com</p>
    </div>

    <img src="{{ $img('footer/logomark.svg') }}" alt="" class="absolute left-1/2 top-1/2 size-[240px] -translate-x-1/2 -translate-y-1/2" width="240" height="240">

    <div class="absolute left-[72px] top-[491px] flex items-center gap-[12px]">
        <div class="flex items-center gap-[2px]">
            @for ($i = 0; $i < 4; $i++)
                <img src="{{ $img('footer/star-full.svg') }}" alt="" class="size-[18px]" width="18" height="18">
            @endfor
            <img src="{{ $img('footer/star-half.svg') }}" alt="" class="size-[18px]" width="18" height="18">
        </div>
        <p class="lum-text-3 font-medium text-lum-ivory">
            4.9 <span class="text-lum-ivory-40">/ 139 reviews</span>
        </p>
    </div>

    <div class="absolute left-[72px] top-[553px] lum-heading-3 text-lum-ivory">
        <p>Thiththagalla road, Walhengoda,</p>
        <p>Ахангама 80650 Шри-Ланка</p>
    </div>

    <div class="absolute left-[72px] top-[635px] flex items-center gap-[10px]">
        <a href="#" class="lum-btn-ivory">SEE on map</a>
        @for ($i = 0; $i < 2; $i++)
            <a href="#" class="flex items-center rounded-[50px] border border-lum-ivory p-[2px]" aria-label="Social">
                <img src="{{ $img('footer/instagram.svg') }}" alt="" class="size-[32px]" width="32" height="32">
            </a>
        @endfor
    </div>

    <nav class="absolute right-[72px] top-[615px] flex gap-[40px] lum-text-2 font-medium text-lum-ivory">
        <a href="#" class="relative">
            Lum Residence
            <img src="{{ $img('footer/link-underline.svg') }}" alt="" class="absolute left-0 top-[26px] w-full" width="120" height="2">
        </a>
        <a href="#">Oculus</a>
        <a href="#">Lum Ocean</a>
        <a href="#">Lum Villas</a>
    </nav>

    <button type="button" class="absolute right-[72px] bottom-[93px] flex size-[40px] -scale-y-100 items-center justify-center rounded-full bg-lum-ivory p-[4px]" aria-label="Back to top">
        <img src="{{ $img('footer/arrow-up.svg') }}" alt="" class="size-[32px]" width="32" height="32">
    </button>

    <div class="lum-divider absolute bottom-[64px] left-[72px] bg-lum-ivory-40 opacity-100"></div>

    <div class="absolute bottom-[32px] left-[72px] lum-text-2 text-lum-ivory-40">©Lum — 2026 all rights Reserved</div>
    <div class="absolute bottom-[32px] left-1/2 flex -translate-x-1/2 gap-[40px] lum-text-2 text-lum-ivory-40">
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Use</a>
    </div>
    <div class="absolute right-[72px] bottom-[32px] lum-text-2 text-right text-lum-ivory-40">Des & Dev / Ivan Taskayev & Roman Falkin</div>
</footer>
