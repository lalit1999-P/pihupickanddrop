<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickupimage extends Model
{
    use HasFactory;
    protected $table = 'pickup_image';
    protected $fillable = ['pickup_image'];
}
