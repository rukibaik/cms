<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceItem extends Model
{
    protected $fillable = [
        'service_id',
        'title',
        'subtitle', // NEW
        'description',
        'image', // NEW
        'sort_order'
    ];
    protected $casts = ['sort_order' => 'integer'];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
