<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Pricing extends Model
{
    protected $fillable = ['name', 'price', 'button_text', 'button_link', 'description', 'is_featured', 'sort_order'];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => (float) $value,
            set: fn($value) => (float) str_replace(',', '', (string) $value),
        );
    }

    public function benefits(): HasMany
    {
        return $this->hasMany(PricingBenefit::class)->orderBy('sort_order');
    }
}
