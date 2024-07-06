<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Task extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['name', 'job_id'];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
