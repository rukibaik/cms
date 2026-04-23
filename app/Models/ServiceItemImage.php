<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceItemImage extends Model
{
    protected $fillable = [
        'service_item_id',
        'image',
    ];
}
