<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $fillable = ['title', 'subtitle', 'description'];

    /**
     * Safely fetch or create the single about record
     */
    public static function getOrCreate(): static
    {
        return static::firstOrCreate(
            [],
            ['title' => 'About Prestige In Media']
        );
    }
}
