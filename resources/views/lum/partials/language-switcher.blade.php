<div
    id="lum-lang-panel"
    class="lum-lang-panel pointer-events-none absolute right-0 top-[calc(100%+8px)] z-[70] hidden w-[320px] opacity-0 transition-opacity duration-150"
    role="dialog"
    aria-label="Select Language"
    aria-hidden="true"
>
    <div class="pointer-events-auto relative h-[154px] w-[320px] bg-lum-green">
        <p class="absolute left-[20px] top-[15px] lum-text-2 text-lum-ivory">Select Language</p>

        <button type="button" class="absolute right-[16px] top-[16px] flex items-center rounded-[50px] bg-lum-orange-2 p-0" data-lum-lang-close aria-label="Close language menu">
            <img src="{{ asset('images/lum/ui/close.svg') }}" alt="" class="size-[24px]" width="24" height="24">
        </button>

        <button type="button" class="absolute left-[20px] top-[71px] text-left font-serif text-[28px] font-medium leading-[34px] tracking-[0.36px] text-lum-ivory-40" data-lum-lang-option="ru">Russian</button>

        <button type="button" class="absolute left-[20px] top-[110px] text-left font-serif text-[28px] font-medium leading-[34px] tracking-[0.36px] text-lum-ivory" data-lum-lang-option="en" aria-current="true">English</button>

        <span class="pointer-events-none absolute right-[28px] top-[110px] font-serif text-[28px] font-medium leading-[34px] text-lum-ivory">✓</span>
    </div>
</div>
