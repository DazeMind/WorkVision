<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    // public function companies()
    // {
    //     return $this->belongsToMany(Company::class, 'companies_projects');
    // }
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'companies_projects', 'id_project', 'id_company');
    }
    public function state()
    {  
        return $this->belongsTo(State::class,'id_state');
    }

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'value',
        'budget',
        'status',
        'address',
        'id_state',
    ];
}
