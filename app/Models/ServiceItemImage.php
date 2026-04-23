<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ServiceItemImage extends Model
{
    protected $fillable = ['service_item_id', 'image', 'sort_order'];
    protected $casts = ['sort_order' => 'integer'];

    public function serviceItem(): BelongsTo
    {
        return $this->belongsTo(ServiceItem::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? asset('storage/' . $value) : null
        );
    }
}
