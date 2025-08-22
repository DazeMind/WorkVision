<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDeliveries extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function order()
    {
        return $this->hasMany(Order::class,'id_order');
    }
    public function region()
    {
        return $this->hasMany(Region::class,'destination_region');
    }
    public function comuna()
    {
        return $this->hasMany(Commune::class,'destination_comuna');
    }
    // public function courier()
    // {
    //     return $this->belongsTo(Courier::class, 'id_courier');
    // }

    protected $fillable = [
        'id_order',
        'shiping_price',// Precio de envío
        'height',
        'weight',
        'width',
        'length',
        'destination_address',
        'destination_comuna',
        'destination_region',
        'origin',
        'delivery_date',
        'id_courier',
    ];


}
