<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Job extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['name', 'amount', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'job_id');
    }
}
