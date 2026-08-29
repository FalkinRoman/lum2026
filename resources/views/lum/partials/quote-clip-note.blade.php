{{-- Line + binder clip + sticky note. Sits BELOW the quote (flex), never through it. --}}
@php
    $size = $size ?? 'mob'; // mob|tab|desk
    $note1 = $note1 ?? '';
    $note2 = $note2 ?? '';
    $cfg = match ($size) {
        'tab' => [
            'lineW' => 'w-[733px]',
            'lineH' => 'h-[2px]',
            'lineAssetW' => 733,
            'lineAssetH' => 2,
            'clipW' => 40,
            'clipH' => 52,
            'clipTop' => '-42px',
            'noteMt' => 'mt-[28px]',
            'noteText' => 'lum-text-2',
            'gapAfterQuote' => 'mt-[44px]',
        ],
        'desk' => [
            'lineW' => 'w-[733px]',
            'lineH' => 'h-[2px]',
            'lineAssetW' => 733,
            'lineAssetH' => 2,
            'clipW' => 40,
            'clipH' => 52,
            'clipTop' => '-42px',
            'noteMt' => 'mt-[28px]',
            'noteText' => 'lum-body',
            'gapAfterQuote' => 'mt-[44px]',
        ],
        default => [
            'lineW' => 'w-[280px]',
            'lineH' => 'h-px',
            'lineAssetW' => 280,
            'lineAssetH' => 1,
            'clipW' => 33,
            'clipH' => 42,
            'clipTop' => '-34px',
            'noteMt' => 'mt-[20px]',
            'noteText' => 'text-[14px] leading-[22px] tracking-[0.1px]',
            'gapAfterQuote' => 'mt-[36px]',
        ],
    };
@endphp

<div
    @class([$cfg['gapAfterQuote'], 'relative flex w-full flex-col items-center'])
    @if ($reveal ?? true)
        data-lum-scroll-reveal
        data-lum-scroll-reveal-delay="{{ $revealDelay ?? '0.12' }}"
    @endif
>
    <div @class(['relative', $cfg['lineW']])>
        <img
            src="{{ $img('stay/quote-line-full.svg') }}"
            alt=""
            @class(['w-full', $cfg['lineH']])
            width="{{ $cfg['lineAssetW'] }}"
            height="{{ $cfg['lineAssetH'] }}"
        >
        <img
            src="{{ $img('stay/clip.png') }}"
            alt=""
            class="pointer-events-none absolute left-1/2 z-[2] -translate-x-1/2 rotate-2"
            style="top: {{ $cfg['clipTop'] }}; width: {{ $cfg['clipW'] }}px; height: {{ $cfg['clipH'] }}px"
            width="{{ $cfg['clipW'] }}"
            height="{{ $cfg['clipH'] }}"
            loading="lazy"
        >
    </div>

    <div @class([
        $cfg['noteMt'],
        'relative z-0 w-[301px] max-w-full bg-lum-cream px-[24px] py-[20px] text-center shadow-[1.3px_1px_1.2px_rgba(0,0,0,0.51)]',
    ])>
        @if (filled($note1))
            <p @class([$cfg['noteText'], 'text-lum-espresso'])>{{ $note1 }}</p>
        @endif
        @if (filled($note2))
            <p @class([$cfg['noteText'], 'text-lum-espresso'])>{{ $note2 }}</p>
        @endif
    </div>
</div>
