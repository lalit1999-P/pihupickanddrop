<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceInvoice extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'service_invoice';
    protected $fillable = ['id', 'invoice_date', 'invoice_amount', 'invoice_payble_amount', 'invoice_image', 'service_order_id'];
}
