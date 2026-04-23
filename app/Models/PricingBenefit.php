<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PricingBenefit extends Model
{
    protected $fillable = ['pricing_id', 'benefit', 'sort_order'];
    protected $casts = ['sort_order' => 'integer'];

    public function pricing(): BelongsTo
    {
        return $this->belongsTo(Pricing::class);
    }
}
