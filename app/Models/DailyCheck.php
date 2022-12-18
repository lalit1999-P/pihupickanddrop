<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyCheck extends Model
{
    use HasFactory;

    protected $table = 'daily_check';
    protected $fillable = ['daily_check'];
}
