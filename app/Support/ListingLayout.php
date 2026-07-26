<?php

namespace App\Support;

/**
 * Generates absolute card positions for listing grids when N ≠ design baseline (3–4).
 */
class ListingLayout
{
    public static function mobileStack(int $count, int $startTop, int $step): array
    {
        return collect(range(0, max(0, $count - 1)))
            ->map(fn (int $i) => ['top' => $startTop + ($i * $step)])
            ->all();
    }

    public static function mobileStay(int $count, ?int $imageTopStart = null): array
    {
        $imageTopStart ??= 495;
        $textOffset = 406; // 901 - 495

        return collect(range(0, max(0, $count - 1)))
            ->map(fn (int $i) => [
                'imageTop' => $imageTopStart + ($i * 546),
                'textTop' => $imageTopStart + $textOffset + ($i * 546),
            ])
            ->all();
    }

    public static function grid2(int $count, array $lefts, int $startTop, int $rowStep): array
    {
        $cols = count($lefts) ?: 2;

        return collect(range(0, max(0, $count - 1)))
            ->map(fn (int $i) => [
                'left' => $lefts[$i % $cols],
                'top' => $startTop + (intdiv($i, $cols) * $rowStep),
            ])
            ->all();
    }

    public static function stayTablet(int $count, ?int $imageTopStart = null): array
    {
        $imageTopStart ??= 615;
        $textOffset = 557; // 1172 - 615

        return collect(range(0, max(0, $count - 1)))
            ->map(fn (int $i) => [
                'left' => $i % 2 === 0 ? 20 : 490,
                'imageTop' => $imageTopStart + (intdiv($i, 2) * 725),
                'textTop' => $imageTopStart + $textOffset + (intdiv($i, 2) * 725),
            ])
            ->all();
    }

    public static function stayDesktop(int $count, ?int $imageTopStart = null): array
    {
        $imageTopStart ??= 942;
        $textOffset = 852; // 1794 - 942

        return collect(range(0, max(0, $count - 1)))
            ->map(fn (int $i) => [
                'left' => $i % 2 === 0 ? 225 : 992,
                'imageTop' => $imageTopStart + (intdiv($i, 2) * 1026),
                'textTop' => $imageTopStart + $textOffset + (intdiv($i, 2) * 1026),
            ])
            ->all();
    }

    public static function sectionHeight(array $layout, string $key, int $padding): int
    {
        if ($layout === []) {
            return $padding;
        }

        $last = $layout[array_key_last($layout)];

        return (int) ($last[$key] ?? 0) + $padding;
    }
}
