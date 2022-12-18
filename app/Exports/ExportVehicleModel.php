<?php

namespace App\Exports;

use App\Models\VehicleModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportVehicleModel implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'ID','Vehicle Model','Created time'
        ];
    }
    public function collection()
    {
        return VehicleModel::select('id','vehicle_model','created_at')->get();
    }
}
