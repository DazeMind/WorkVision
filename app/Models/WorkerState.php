<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerState extends Model
{ 
    public function worker()
    {  
        return $this->hasMany(Worker::class);
    }

    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];
}
