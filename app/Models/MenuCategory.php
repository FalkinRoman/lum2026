<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class MenuCategory extends Model
{
    use HasTranslations;

    protected $fillable = ['restaurant_id', 'key', 'sort_order', 'label'];

    public array $translatable = ['label'];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }

    public function scopeForRestaurant(Builder $query, int|string $restaurantId): Builder
    {
        return $query->where('restaurant_id', $restaurantId);
    }
}
