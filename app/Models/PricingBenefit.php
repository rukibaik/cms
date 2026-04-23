<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingBenefit extends Model
{
    protected $fillable = [
        'pricing_id',
        'benefit',
    ];
}
