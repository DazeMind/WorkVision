<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory;
    use SoftDeletes;

    // public function company()
    // {
    //     return $this->hasMany(Company::class,'id_company');
    // }
    // public function invoices()
    // {
    //     return $this->belongsTo(Project::class, 'companies_projects', 'id_company', 'id_project');
    // }

    protected $fillable = [
        'id_company',
        'name',
        'type',
        'unit_of_measure', //gramos, metros , litros, unidad
        'stock', //(solo si se gestiona stock)
        'purchase_price',
        'low_stock_threshold', //minimo de existencias
        'description',
    ];
}

  