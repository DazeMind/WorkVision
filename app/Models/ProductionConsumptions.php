<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionConsumptions extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id_production_order',
        'component_type',
        'id_component', //cuantas unidades se producen
        'quantity_used',
        'unit_cost',
    ];
}