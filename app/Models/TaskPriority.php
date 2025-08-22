<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskPriority extends Model
{
    use HasFactory;
    use SoftDeletes;

    // public function worker_project()
    // {  
    //     return $this->belongsTo(WorkersProjects::class,'id_worker_project');
    // }

    protected $fillable = [
        'name',
        'color',
    ];
}
