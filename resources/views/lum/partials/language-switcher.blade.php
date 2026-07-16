@php
    $locale = app()->getLocale();
@endphp
<div
    id="{{ $panelId ?? 'lum-lang-panel' }}"
    class="lum-lang-panel pointer-events-none absolute right-0 top-[calc(100%+8px)] z-[5100] w-[320px]"
    hidden
    role="dialog"
    aria-label="{{ __('lum.lang.select') }}"
    aria-hidden="true"
>
    <div class="lum-lang-panel__card pointer-events-auto relative h-[154px] w-[320px] bg-lum-green desk:h-[160px]">
        <p class="absolute left-[20px] top-[15px] font-normal lum-text-2 text-lum-ivory desk:left-[24px]">{{ __('lum.lang.select') }}</p>

        <button
            type="button"
            class="lum-lang-panel__close absolute top-[16px] tab:left-[268px] desk:left-[280px]"
            data-lum-lang-close
            aria-label="{{ __('lum.lang.close') }}"
        >
            <svg class="lum-lang-panel__close-icon relative z-[1] block size-[12px]" viewBox="0.75 0.75 9.7954 9.7954" fill="none" aria-hidden="true">
                <path d="M10.5454 1.54541L6.44312 5.64771L10.5454 9.75L9.75 10.5454L5.64771 6.44312L1.54541 10.5454L0.75 9.75L4.85229 5.64771L0.75 1.54541L1.54541 0.75L5.64771 4.85229L9.75 0.75L10.5454 1.54541Z" fill="currentColor"/>
            </svg>
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
