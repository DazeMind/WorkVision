<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkersProjects extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function worker()
    {  
        return $this->belongsTo(Worker::class,'id_worker');
    }
    public function project()
    {  
        return $this->belongsTo(Project::class,'id_project');
    }
    public function state()
    {  
        return $this->belongsTo(State::class,'id_state');
    }
    protected $fillable = [
        'id_worker',
        'id_project',
        'role',
        'id_state',
    ];
}
