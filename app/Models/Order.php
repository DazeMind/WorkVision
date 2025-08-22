<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function company()
    {
        return $this->belongsTo(Company::class, 'id_shop_order');
    }
    public function state()
    {
        return $this->belongsTo(OrderState::class, 'id_state');
    }
    public function consumer()
    {
        return $this->belongsTo(Consumer::class,'id_consumer');
    }

    public function orderDeliveries()
    {
        return $this->hasMany(OrderDeliveries::class, 'id_order');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_order');
    }

    // public function invoices()
    // {
    //     return $this->belongsTo(Project::class, 'companies_projects', 'id_company', 'id_project');
    // }
    protected $table = 'orders';

    protected $fillable = [
        'id_consumer',
        'id_shop_order',
        'id_invoice',
        'order_date',
        'id_state',
        'sale_price',
        'discounts',
        'total_amount',
        'amount_paid',
        'note',
        'payment_date',

    ];
}
