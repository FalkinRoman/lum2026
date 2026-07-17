@php
    $width = $width ?? 79;
    $tone = $tone ?? 'green';
    $fullWidth = $fullWidth ?? false;
    $graphicClass = $graphicClass ?? 'mt-[4px]';

    [$file, $viewBox, $fill] = match ($tone) {
        'rose' => ['images/lum/blog/underline-rose.svg', '0 0 79 2', '#f56f31'],
        'ivory' => ['images/lum/footer/link-underline.svg', '0 0 108 2', '#FFFDDF'],
        'espresso' => ['images/lum/blog/underline.svg', '0 0 79 2', '#2E2720'],
        default => ['images/lum/blog/underline.svg', '0 0 79 2', '#41606B'],
    };

    $svgContent = file_get_contents(public_path($file));
    preg_match('/<path\b[^>]*\sd="([^"]+)"/', $svgContent, $pathMatch);

    $pathD = $pathMatch[1] ?? '';
@endphp

<span
    @class(['lum-link__line lum-link__graphic', $graphicClass, 'w-full' => $fullWidth])
    @if (! $fullWidth) style="width: {{ $width }}px" @endif
>
    <svg
        class="lum-link__line-svg"
        width="100%"
        height="2"
        viewBox="{{ $viewBox }}"
        preserveAspectRatio="none"
        aria-hidden="true"
        focusable="false"
    >
        <path class="lum-link__line-path" d="{{ $pathD }}" fill="{{ $fill }}" />
    </svg>
</span>
