<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Project extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['name', 'price', 'account_id'];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'project_id');
    }
}
