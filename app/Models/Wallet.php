<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    public function client()
    {  
        return $this->belongsTo(Client::class,'id_client');
    }
    public function walletType()
    {  
        return $this->hasMany(WalletType::class, 'id_type');
    }
    public function state()
    {  
        return $this->hasMany(State::class,'id_state');
    }
    public function records()
    {
        return $this->hasMany(Record::class,'id_wallet');
    }
    
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id_client',
        'id_type',
        'name',
        'amount',
        'currency',
        'number_account',
        'color',
        'id_state',
    ];
}
