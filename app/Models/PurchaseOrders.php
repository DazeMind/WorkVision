<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrders extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id_company',
        'id_supplier',
        'reference',
        'total_amount',
        'purchase_date',
        'notes',
    ];
}
