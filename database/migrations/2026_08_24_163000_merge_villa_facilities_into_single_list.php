<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $rows = DB::table('villas')->select('id', 'facilities_left', 'facilities_right')->get();

        foreach ($rows as $row) {
            $left = json_decode($row->facilities_left ?? 'null', true);
            $right = json_decode($row->facilities_right ?? 'null', true);

            if (! is_array($left)) {
                $left = [];
            }
            if (! is_array($right)) {
                $right = [];
            }

            $merged = $this->mergeLocaleLists($left, $right);

            DB::table('villas')->where('id', $row->id)->update([
                'facilities_left' => $merged === [] ? null : json_encode($merged, JSON_UNESCAPED_UNICODE),
                'facilities_right' => null,
            ]);
        }
    }

    public function down(): void
    {
        // Irreversible merge — left keeps the full list, right stays empty.
    }

    /**
     * @param  array<string, mixed>  $left
     * @param  array<string, mixed>  $right
     * @return array<string, list<string>>
     */
    private function mergeLocaleLists(array $left, array $right): array
    {
        $looksLocalized = $this->isLocaleMap($left) || $this->isLocaleMap($right);

        if (! $looksLocalized) {
            $flat = array_values(array_filter(
                array_merge(
                    array_values(array_filter($left, fn ($v) => is_string($v))),
                    array_values(array_filter($right, fn ($v) => is_string($v))),
                ),
                fn (string $v) => filled($v),
            ));

            return $flat === [] ? [] : ['en' => $flat];
        }

        $locales = array_unique(array_merge(array_keys($left), array_keys($right)));
        $merged = [];

        foreach ($locales as $locale) {
            $l = $left[$locale] ?? [];
            $r = $right[$locale] ?? [];
            if (! is_array($l)) {
                $l = filled($l) ? [(string) $l] : [];
            }
            if (! is_array($r)) {
                $r = filled($r) ? [(string) $r] : [];
            }

            $items = array_values(array_filter(
                array_merge($l, $r),
                fn ($v) => is_string($v) && filled($v),
            ));

            if ($items !== []) {
                $merged[$locale] = $items;
            }
        }

        return $merged;
    }

    /**
     * @param  array<mixed>  $value
     */
    private function isLocaleMap(array $value): bool
    {
        if ($value === []) {
            return false;
        }

        foreach (array_keys($value) as $key) {
            if (! is_string($key) || ! preg_match('/^[a-z]{2}(_[A-Z]{2})?$/', $key)) {
                return false;
            }
        }

        return true;
    }
};
