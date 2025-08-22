<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsService extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function company()
    {
        return $this->belongsTo(Company::class,'id_company');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_product');
    }

    // public function invoices()
    // {
    //     return $this->belongsTo(Project::class, 'companies_projects', 'id_company', 'id_project');
    // }

    protected $fillable = [
        'id_company',
        'name',
        'type',
        'is_fabricable',
        'is_resellable',
        'unit_of_measure', //gramos, metros , litros, unidad
        'purchase_price',
        'sale_price',
        'stock', //(solo si se gestiona stock)
        'average_cost',
        'markup_percentage',
        'description',
        'SKU',
        'height',
        'weight',
        'width',
        'length',
    ];
}