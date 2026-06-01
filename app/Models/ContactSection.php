<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSection extends Model
{
    protected $fillable = [
        'eyebrow',
        'title',
        'subtitle',
        'whatsapp_number',
        'email',
        'phone',
        'address',
        'button_text',
    ];

    public static function getOrCreate(): static
    {
        return static::firstOrCreate([], static::defaults());
    }

    public static function defaults(): array
    {
        return [
            'eyebrow' => 'Contact',
            'title' => 'Let us build your next campaign',
            'subtitle' => 'Tell us what you need and our team will follow up via WhatsApp.',
            'whatsapp_number' => '6281234567890',
            'email' => 'hello@prestigeinmedia.com',
            'phone' => '+62 812 3456 7890',
            'address' => 'Jakarta, Indonesia',
            'button_text' => 'Send via WhatsApp',
        ];
    }
}