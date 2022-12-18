<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleVariant extends Model
{
    use HasFactory;

    protected $table = 'vehicle_variant';

    protected $fillable = [
        'id', 'user_id', 'vehicle_model', 'vehicle_variant', 'created_at', 'updated_at'
    ];

    public function VehicleModel()
    {
        return $this->hasOne(VehicleModel::class, 'id', 'vehicle_model');
    }
}
