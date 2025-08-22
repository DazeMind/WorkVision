<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventorySnapshotItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'snapshot_id',
        'id_product_service',
        'id_material', 
        'quantity', 
        'unit_of_measure',//gramos, metros , litros, unidad
        'expected_quantity',
    ];
}