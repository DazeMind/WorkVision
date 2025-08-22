<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Companies_projects extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function companies()
    {  
        return $this->belongsTo(Company::class,'id_company');
    }

    public function projects()
    {  
        return $this->belongsTo(Project::class,'id_project');
    }

    public function state()
    {  
        return $this->belongsTo(State::class,'id_state');
    }

    protected $fillable = [
        'id_company',
        'id_project',
        'id_state',
    ];
}
