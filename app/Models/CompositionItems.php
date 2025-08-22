<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompositionItems extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id_product_composition',
        'id_component',
        'component_type', //material o producto
        'quantity_required', 
        'unit_cost_snapshot',
    ];
}