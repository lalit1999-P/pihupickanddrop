<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syclist extends Model
{
    use HasFactory;
    protected $table = 'syclist';
    protected $fillable = ['syclist'];
}
