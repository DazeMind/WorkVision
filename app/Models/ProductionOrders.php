<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionOrders extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id_company',
        'id_product_service',
        'id_composition',
        'quantity_produced',
        'produced_at',
        'total_cost_real',
        'notes',
    ];
}