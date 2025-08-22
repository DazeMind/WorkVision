<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TasksState extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function taks()
    {  
        return $this->hasMany(Task::class);
    }

    protected $fillable = [
        'name',
        'description',
    ];
}
