<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dropoffimage extends Model
{
    use HasFactory;
    protected $table = 'drop_off_image';
    protected $fillable = ['drop_off_image', 'order_id', "driver_id", 'image1', "image2", "image3", "image4", "image5"];
}
