<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    public function wallet()
    {  
        return $this->hasMany(Wallet::class);
    }
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'description',
    ];
}
