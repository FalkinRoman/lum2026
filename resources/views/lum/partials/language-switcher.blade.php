@php
    $locale = app()->getLocale();
@endphp
<div
    id="{{ $panelId ?? 'lum-lang-panel' }}"
    class="lum-lang-panel pointer-events-none absolute right-0 top-[calc(100%+8px)] z-[5100] hidden w-[320px] opacity-0 transition-opacity duration-200"
    hidden
    role="dialog"
    aria-label="{{ __('lum.lang.select') }}"
    aria-hidden="true"
>
    <div class="pointer-events-auto relative h-[154px] w-[320px] bg-lum-green desk:h-[160px]">
        <p class="absolute left-[20px] top-[15px] font-normal lum-text-2 text-lum-ivory desk:left-[24px]">{{ __('lum.lang.select') }}</p>

        <button type="button" class="lum-lang-panel__close absolute top-[16px] flex items-center rounded-[50px] bg-lum-orange-2 tab:left-[268px] desk:left-[280px]" data-lum-lang-close aria-label="{{ __('lum.lang.close') }}">
            <span class="flex size-[24px] shrink-0 items-center justify-center">
                <img src="{{ asset('images/lum/ui/close.svg') }}" alt="" class="size-[13.060546875px]" width="13" height="13">
            </span>
        </button>

        <a
            href="{{ route('locale.switch', 'ru') }}"
            @class([
                'lum-lang-option absolute left-[20px] top-[71px] text-left font-serif text-[28px] font-medium leading-[34px] tracking-[0.3636px] desk:top-[72px] desk:text-[32px] desk:leading-[36px] desk:tracking-[0.32px]',
                'is-active text-lum-ivory' => $locale === 'ru',
                'text-lum-ivory-40' => $locale !== 'ru',
            ])
            @if ($locale === 'ru') aria-current="true" @endif
        >
            {{ __('lum.lang.russian') }}
        </a>

        <a
            href="{{ route('locale.switch', 'en') }}"
            @class([
                'lum-lang-option absolute left-[20px] top-[110px] text-left font-serif text-[28px] font-medium leading-[34px] tracking-[0.3636px] desk:text-[32px] desk:leading-[36px] desk:tracking-[0.32px]',
                'is-active text-lum-ivory' => $locale === 'en',
                'text-lum-ivory-40' => $locale !== 'en',
            ])
            @if ($locale === 'en') aria-current="true" @endif
        >
            {{ __('lum.lang.english') }}
        </a>

        <span class="lum-lang-panel__check pointer-events-none absolute font-serif text-[28px] font-medium leading-[34px] tracking-[0.3636px] text-lum-ivory tab:left-[280px] tab:-translate-x-1/2 desk:text-[32px] desk:leading-[36px] desk:tracking-[0.32px] desk:left-[290.5px]" style="top: {{ $locale === 'ru' ? '71px' : '110px' }}">✓</span>
    </div>
</div>
