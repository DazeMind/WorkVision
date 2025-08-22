<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    public function client()
    {  
        return $this->belongsTo(Client::class,'id_client');
    }
    public function state()
    {  
        return $this->belongsTo(State::class,'id_state');
    }
    public function workers()
    {
        return $this->belongsToMany(Worker::class, 'worker_companies', 'id_company', 'id_worker');
    }
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'companies_projects', 'id_company', 'id_project');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'id_shop_order');
    }

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id_client',
        'name',
        'email',
        'rut',
        'phone',
        'address',
        'type',
        'creation_date',
        'id_state',
    ];
}
