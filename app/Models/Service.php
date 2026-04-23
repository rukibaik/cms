<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
    ];

    public function items()
    {
        return $this->hasMany(ServiceItem::class);
    }
}
