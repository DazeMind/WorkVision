<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suppliers extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id_company',
        'name',
        'email',
        'phone',
        'address',
        'notes',
    ];
}
