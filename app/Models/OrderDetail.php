<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function order()
    {
        return $this->belongsTo(Order::class,'id_order');
    }
    public function product()
    {
        return $this->belongsTo(ProductsService::class,'id_product')->withTrashed();
    }
    public function state()
    {
        return $this->belongsTo(OrderState::class,'id_state');
    }
    // public function courier()
    // {
    //     return $this->belongsTo(Courier::class, 'id_courier');
    // }

    protected $fillable = [
        'id_order',
        'id_product',
        'quantity',
        'discount',
        'price',
        'total',
        'tax',
        'id_state',
    ];
}
