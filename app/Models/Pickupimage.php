<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickupimage extends Model
{
    use HasFactory;
    protected $table = 'pickup_image';
    protected $fillable = ['pickup_image', 'driver_id', 'order_id', 'image1', 'image2', 'image3', 'image4', 'image5','image6', 'image7', 'image8', 'image9', 'image10'];
}
