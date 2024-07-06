<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\Task;

class AccountRepository
{
    public function getAll()
    {
        return Account::with('projects.jobs.tasks')->get();
    }

    public function getTasksUnderPrice($price)
    {
        return Task::whereHas('job.project', function ($query) use ($price) {
            $query->where('price', '<', $price);
        })->get();
    }
}