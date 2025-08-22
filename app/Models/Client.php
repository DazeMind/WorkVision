<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{ 
    public function user()
    {  
        return $this->belongsTo(User::class,'id_user');
    }
    public function state()
    {  
        return $this->belongsTo(State::class,'id_state');
    }
    public function bankData()
    {  
        return $this->hasMany(BankData::class,'id_client');
    }
    public function company()
    {  
        return $this->hasMany(Company::class,'id_client');
    }

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id_user',
        'full_name',
        'rut',
        'address',
        'phone',
        'email',
        'membership',
        'id_state',
    ];
}