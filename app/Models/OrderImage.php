<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderImage extends Model
{
    protected $table = 'order_image';
    protected $fillable = [
        'id',
        "order_id",
        "img_url",
        "type",
        "created_at",
        "updated_at",
    ];
    use HasFactory;
}
