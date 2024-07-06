<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Tweet extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['tweet', 'useruid', 'datetime'];
}

