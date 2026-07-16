@php
    $total = $total ?? 7;
    $startIndex = $startIndex ?? 0;
    $itemClass = $itemClass ?? 'w-[42px]';
    $gapClass = $gapClass ?? 'gap-[14px]';
@endphp
<div class="flex w-full items-start justify-center {{ $gapClass }}" data-lum-interior-progress>
    @for ($i = 0; $i < $total; $i++)
        <span
            @class(['lum-interior-progress__item inline-flex h-[19px] flex-col items-center', $itemClass])
            data-lum-interior-progress-item
            data-index="{{ $i }}"
        >
            <span class="lum-interior-progress__track relative mt-0 block h-px w-full overflow-hidden bg-lum-espresso/40">
                <span
                    class="lum-interior-progress__fill absolute inset-y-0 left-0 w-full origin-left bg-lum-orange-2"
                    data-lum-interior-progress-fill
                ></span>
            </span>
            <span
                class="lum-interior-progress__dot mt-[12px] size-[6px] shrink-0 rounded-full bg-lum-orange-2"
                data-lum-interior-progress-dot
                @class(['opacity-100' => $i === $startIndex, 'opacity-0' => $i !== $startIndex])
                aria-hidden="true"
            ></span>
        </span>
    @endfor
</div>
