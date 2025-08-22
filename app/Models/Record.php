<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function wallet()
    {  
        return $this->belongsTo(Wallet::class,'id_wallet');
    }
    public function category()
    {  
        return $this->belongsTo(Category::class,'id_category');
    }
    public function shceduleRecord()
    {  
        return $this->belongsTo(ScheduleRecord::class,'id_record');
    }

    protected $fillable = [
        'id_wallet',
        'amount',
        'id_category',
        'description',
        'date',
        'document',
        'type',
    ];
}