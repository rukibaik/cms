<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class HeroSection extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'button_text',
        'button_link',
        'background_image'
    ];

    protected function casts(): array
    {
        return ['background_image' => 'string'];
    }

    protected function backgroundImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? asset('storage/' . $value) : null
        );
    }

    /**
     * Safely fetch or create the single hero record
     */
    public static function getOrCreate(): static
    {
        return static::firstOrCreate(
            [],
            ['title' => 'Welcome to Our Agency']
        );
    }
}
