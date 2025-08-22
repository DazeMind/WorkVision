<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkerCompany extends Model
{
    public function state()
    {  
        return $this->belongsTo(State::class,'id_state');
    }
    public function company()
    {  
        return $this->belongsTo(Company::class,'id_company');
    }
    public function worker()
    {  
        return $this->belongsTo(Worker::class,'id_worker');
    }
    use HasFactory;
    use SoftDeletes;
    protected $table = 'worker_companies';
    protected $fillable = [
        'id_worker',
        'id_company',
        'id_state',
    ];
}
