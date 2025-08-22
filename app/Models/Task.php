<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project');
    }
    
    public function state()
    {  
        return $this->belongsTo(TasksState::class,'id_state');
    }
    public function priority()
    {  
        return $this->belongsTo(TaskPriority::class,'id_task_priority');
    }
    public function worker_project()
    {  
        return $this->belongsTo(WorkersProjects::class,'id_worker_project');
    }

    protected $fillable = [
        'id_project',
        'id_worker_project',
        'title',
        'description',
        'id_task_priority',
        'date',
        'time',
        'id_state',
    ];
}