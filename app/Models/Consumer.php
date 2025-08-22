<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumer extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function orders()
    {
        return $this->belongsTo(Order::class, 'id_consumer');
    }
    public function company()
    {
        return $this->hasMany(Company::class, 'id_company');
    }

    protected $fillable = [
        'id_company',
        'name',
        'email',
        'phone',
        'address',
    ];
}