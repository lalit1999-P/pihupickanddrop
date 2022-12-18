<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use HasFactory;

    protected $table = 'vehicle_model';

    protected $fillable = [
        'id', 'user_id', 'vehicle_model', 'created_at', 'updated_at'
    ];

}
