<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'subcategory';

    protected $fillable = [
        'id', 'category_id', 'subcategory', 'slug', 'image', 'created_at', 'updated_at'     ];

    public function Category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
