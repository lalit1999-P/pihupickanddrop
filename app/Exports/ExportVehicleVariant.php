<?php

namespace App\Exports;

use App\Models\VehicleVariant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportVehicleVariant implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'Vehicle Variant Name', 'Vehicle Model', 'Created time'
        ];
    }
    public function collection()
    {
        return VehicleVariant::leftjoin('vehicle_model', 'vehicle_model.id', 'vehicle_variant.vehicle_model')->select('vehicle_variant.vehicle_variant', 'vehicle_model.vehicle_model', 'vehicle_variant.created_at')->get();
    }
}
