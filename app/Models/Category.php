<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    public function wallet()
    {  
        return $this->belongsTo(Wallet::class,'id_wallet');
    }
    public function subCategory()
    {  
        return $this->hasMany(SubCategory::class,'id_category');
    }

    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'color',
        'icon',
        'id_state',
        'id_client',
        'type',
    ];
}