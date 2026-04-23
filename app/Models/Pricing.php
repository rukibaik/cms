<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    protected $fillable = [
        'name',
        'price',
        'button_text',
        'button_link',
        'description',
    ];

    public function benefits()
    {
        return $this->hasMany(PricingBenefit::class);
    }
}
