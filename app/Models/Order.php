<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'id', 'user_id', 'pick_up_date', 'pick_up_time', 'drop_off_date', 'drop_off_time', 'driver_id', 'location_id', 'price',
        'payble_amount', 'category_id', 'reg_number', 'mobile_no', 'vehicle_model', 'vehicle_variant', 'full_name',
        'sur_name', 'email_id', 'address', 'pickup_address', 'drop_address', 'street_name', 'houser_no', 'landmark', 'service_date',
        'service_detail', 'service_type', 'payment_method', 'invoice_date', 'created_at', 'updated_at'
    ];

    public function Users()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function DriverUsers()
    {
        return $this->hasOne(User::class, 'id', 'driver_id');
    }
    public function Category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    public function Varient()
    {
        return $this->hasOne(VehicleVariant::class, 'id', 'vehicle_variant');
    }

    public function vehicleModel()
    {
        return $this->hasOne(VehicleModel::class, 'id', 'vehicle_model');
    }
    public function location()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }
}
