<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleRecord extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function state()
    {  
        return $this->belongsTo(State::class,'id_state');
    }
    public function record()
    {  
        return $this->belongsTo(Record::class,'id_record');
    }
    protected $table = 'scheduled_records';

    protected $fillable = [
        'DOTM',
        'id_record',
        'next_execution',
        'id_state',
    ];
}