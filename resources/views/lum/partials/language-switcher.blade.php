@php
    $locale = app()->getLocale();
    $options = [
        'ru' => __('lum.lang.russian'),
        'en' => __('lum.lang.english'),
        'zh' => __('lum.lang.chinese'),
    ];
@endphp
<div
    id="{{ $panelId ?? 'lum-lang-panel' }}"
    class="lum-lang-panel pointer-events-none absolute right-0 top-[calc(100%+8px)] z-[5100] w-[320px]"
    hidden
    role="dialog"
    aria-label="{{ __('lum.lang.select') }}"
    aria-hidden="true"
>
    <div class="lum-lang-panel__card pointer-events-auto relative flex w-[320px] flex-col bg-lum-green px-[20px] pb-[20px] pt-[15px] desk:px-[24px] desk:pb-[24px] desk:pt-[16px]">
        <div class="relative mb-[20px] flex items-start justify-between">
            <p class="font-normal lum-text-2 text-lum-ivory">{{ __('lum.lang.select') }}</p>
            <button
                type="button"
                class="lum-lang-panel__close shrink-0"
                data-lum-lang-close
                aria-label="{{ __('lum.lang.close') }}"
            >
                <svg class="lum-lang-panel__close-icon relative z-[1] block size-[12px]" viewBox="0.75 0.75 9.7954 9.7954" fill="none" aria-hidden="true">
                    <path d="M10.5454 1.54541L6.44312 5.64771L10.5454 9.75L9.75 10.5454L5.64771 6.44312L1.54541 10.5454L0.75 9.75L4.85229 5.64771L0.75 1.54541L1.54541 0.75L5.64771 4.85229L9.75 0.75L10.5454 1.54541Z" fill="currentColor"/>
                </svg>
            </button>
        </div>

        <div class="flex flex-col gap-[6px]">
            @foreach ($options as $code => $label)
                <a
                    href="{{ route('locale.switch', $code) }}"
                    @class([
                        'lum-lang-option relative flex items-center justify-between text-left font-serif text-[28px] font-medium leading-[34px] tracking-[0.3636px] desk:text-[32px] desk:leading-[36px] desk:tracking-[0.32px]',
                        'is-active text-lum-ivory' => $locale === $code,
                        'text-lum-ivory-40' => $locale !== $code,
                    ])
                    @if ($locale === $code) aria-current="true" @endif
                >
                    <span>{{ $label }}</span>
                    @if ($locale === $code)
                        <span class="lum-lang-panel__check pointer-events-none font-serif text-[28px] font-medium leading-[34px] tracking-[0.3636px] text-lum-ivory desk:text-[32px] desk:leading-[36px] desk:tracking-[0.32px]" aria-hidden="true">✓</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
