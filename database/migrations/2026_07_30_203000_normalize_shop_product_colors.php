<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach (DB::table('shop_products')->select(['id', 'colors'])->get() as $row) {
            if ($row->colors === null || $row->colors === '') {
                continue;
            }

            $items = is_string($row->colors) ? json_decode($row->colors, true) : $row->colors;
            if (! is_array($items)) {
                continue;
            }

            $normalized = [];
            foreach (array_values($items) as $item) {
                if (is_string($item) && trim($item) !== '') {
                    $path = ltrim($item, '/');
                    $normalized[] = [
                        'kind' => preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/', $path)
                            ? 'hex'
                            : 'image',
                        'image' => preg_match('/^#/', $path) ? null : $path,
                        'hex' => preg_match('/^#/', $path) ? $path : null,
                    ];

                    continue;
                }

                if (! is_array($item)) {
                    continue;
                }

                $kind = ($item['kind'] ?? null) === 'hex' ? 'hex' : 'image';
                $image = filled($item['image'] ?? null) ? ltrim((string) $item['image'], '/') : null;
                $hex = filled($item['hex'] ?? null) ? (string) $item['hex'] : null;

                if ($kind === 'hex' && $hex) {
                    $normalized[] = ['kind' => 'hex', 'image' => null, 'hex' => $hex];
                } elseif ($image) {
                    $normalized[] = ['kind' => 'image', 'image' => $image, 'hex' => null];
                }
            }

            DB::table('shop_products')->where('id', $row->id)->update([
                'colors' => json_encode($normalized, JSON_UNESCAPED_UNICODE),
            ]);
        }
    }

    public function down(): void
    {
        foreach (DB::table('shop_products')->select(['id', 'colors'])->get() as $row) {
            if ($row->colors === null || $row->colors === '') {
                continue;
            }

            $items = is_string($row->colors) ? json_decode($row->colors, true) : $row->colors;
            if (! is_array($items)) {
                continue;
            }

            $flat = [];
            foreach (array_values($items) as $item) {
                if (is_string($item) && trim($item) !== '') {
                    $flat[] = $item;

                    continue;
                }
                if (! is_array($item)) {
                    continue;
                }
                if (($item['kind'] ?? '') === 'hex' && filled($item['hex'] ?? null)) {
                    $flat[] = (string) $item['hex'];
                } elseif (filled($item['image'] ?? null)) {
                    $flat[] = (string) $item['image'];
                }
            }

            DB::table('shop_products')->where('id', $row->id)->update([
                'colors' => json_encode($flat, JSON_UNESCAPED_UNICODE),
            ]);
        }
    }
};
