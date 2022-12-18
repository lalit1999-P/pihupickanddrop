<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Order;

class ExportOrder implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'Id',
            'Pick up',
            'Drop Off',
            'price',
            'Drivername',
            'Reg Number',
            'Mobile No',
            'Vehicle Model',
            'Vehicle Variant',
            'First Name',
            'Last Name',
            'Sur Name',
            'Email Id',
            'Address',
            'Street Name',
            'Houser No',
            'Landmark',
            'Service Date',
            'Service Detail',
            'Created time'
        ];
    }
    public function collection()
    {
        return Order::leftjoin('users', 'users.id', 'orders.driver_id')
            ->leftjoin('vehicle_model', 'vehicle_model.id', 'orders.vehicle_model')
            ->leftjoin('vehicle_variant', 'vehicle_variant.id', 'orders.vehicle_variant')
            ->select(
                'orders.id',
                'orders.pick_up',
                'orders.drop_off',
                'orders.price',
                'users.name',
                'orders.reg_number',
                'orders.mobile_no',
                'vehicle_model.vehicle_model',
                'vehicle_variant.vehicle_variant',
                'orders.first_name',
                'orders.last_name',
                'orders.sur_name',
                'orders.email_id',
                'orders.address',
                'orders.street_name',
                'orders.houser_no',
                'orders.landmark',
                'orders.service_date',
                'orders.service_detail',
                'orders.created_at'
            )->get();
    }
}
