<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{
    public function state()
    {  
        return $this->belongsTo(WorkerState::class,'id_state');
    }
    public function attendance()
    {  
        return $this->hasMany(Attendance::class,'id_worker');
    }
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'worker_companies', 'id_worker', 'id_company');
    }
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'first_name',
        'second_name',
        'first_last_name',
        'second_last_name',
        'rut',
        'email',
        'phone',
        'address',
        'date_of_birth',
        'afp',
        'health_plan',
        'password',
        'id_state',
    ];
}
