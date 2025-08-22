<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankData extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function client()
    {  
        return $this->belongsTo(Client::class,'id_client');
    }
    public function bank()
    {  
        return $this->belongsTo(Bank::class,'id_bank');
    }
    public function BankAccountType()
    {  
        return $this->belongsTo(BankAccountType::class,'id_bank_account_type');
    }

    protected $fillable = [
        'id_client',
        'id_bank',
        'id_bank_account_type',
        'account_number',
        'id_state',
    ];
}
