<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportEmployee implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Name','Email','Contact','Status','Address','Created time'
        ];
    }
    public function collection()
    {
        return User::where('user_type',3)->select('name','email','contact','status','address','created_at')->get();
    }
}
