<div
    id="{{ $panelId ?? 'lum-lang-panel' }}"
    class="lum-lang-panel pointer-events-none absolute right-0 top-[calc(100%+8px)] z-[70] hidden w-[320px] opacity-0 transition-opacity duration-200"
    role="dialog"
    aria-label="Select Language"
    aria-hidden="true"
>
    <div class="pointer-events-auto relative w-[320px] bg-lum-green tab:h-[154px] desk:h-[160px]">
        <p class="absolute left-[20px] top-[15px] font-normal lum-text-2 text-lum-ivory desk:left-[24px]">Select Language</p>

        <button type="button" class="lum-lang-panel__close absolute top-[16px] flex items-center rounded-[50px] bg-lum-orange-2 tab:left-[268px] desk:left-[280px]" data-lum-lang-close aria-label="Close language menu">
            <span class="flex size-[24px] shrink-0 items-center justify-center">
                <img src="{{ asset('images/lum/ui/close.svg') }}" alt="" class="size-[13.060546875px]" width="13" height="13">
            </span>
        </button>

        <button
            type="button"
            class="lum-lang-option absolute left-[20px] top-[71px] text-left font-serif text-[28px] font-medium leading-[34px] tracking-[0.3636px] text-lum-ivory-40 desk:top-[72px] desk:text-[32px] desk:leading-[36px] desk:tracking-[0.32px]"
            data-lum-lang-option="ru"
        >
            Russian
        </button>

        <button
            type="button"
            class="lum-lang-option is-active absolute left-[20px] top-[110px] text-left font-serif text-[28px] font-medium leading-[34px] tracking-[0.3636px] text-lum-ivory desk:text-[32px] desk:leading-[36px] desk:tracking-[0.32px]"
            data-lum-lang-option="en"
            aria-current="true"
        >
            English
        </button>

        <span class="lum-lang-panel__check pointer-events-none absolute top-[110px] font-serif text-[28px] font-medium leading-[34px] tracking-[0.3636px] text-lum-ivory tab:left-[280px] tab:-translate-x-1/2 desk:text-[32px] desk:leading-[36px] desk:tracking-[0.32px] desk:left-[290.5px]">✓</span>
    </div>
</div>
