<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Account extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['name'];

    public function projects()
    {
        return $this->hasMany(Project::class, 'account_id');
    }
}
