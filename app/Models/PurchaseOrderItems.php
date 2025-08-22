<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderItems extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id_purchase_order',
        'id_product_service',
        'quantity',
        'unit_price',
        'total',
        'received',

    ];

}
