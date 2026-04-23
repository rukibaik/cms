<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceSectionSetting extends Model
{
    protected $fillable = ['title', 'subtitle', 'button_text', 'button_link'];

    public static function getOrCreate(): static
    {
        return static::firstOrCreate(
            [],
            ['title' => 'Layanan Kami', 'subtitle' => 'Solusi digital yang dirancang untuk pertumbuhan bisnis Anda.']
        );
    }
}
