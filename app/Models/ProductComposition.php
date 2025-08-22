<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductComposition extends Model
{
    use HasFactory;
    use SoftDeletes;

     protected $fillable = [
        'product_service_id',
        'version',
        'yield_quantity', //cuantas unidades se producen
        'unit_of_yield',
        'description',
        'estimated_cost',
        'is_active',
    ];
}
