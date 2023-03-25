<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrderImage extends Model
{
    use HasFactory;

    protected $table = 'service_order_image';
    protected $fillable = [
        'id',
        "image",
        "service_order_id",
        "service_order_image_type",
        "created_at",
        "updated_at",
    ];
}
