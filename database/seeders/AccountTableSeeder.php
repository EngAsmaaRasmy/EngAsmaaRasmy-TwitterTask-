<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Job;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        Account::truncate();
        Project::truncate();
        Job::truncate();
        Task::truncate();

        // Insert sample data
        $account1 = Account::create(['name' => 'Account 1']);
        $account2 = Account::create(['name' => 'Account 2']);

        $project1 = Project::create(['name' => 'Project 1', 'price' => 50, 'account_id' => $account1->id]);
        $project2 = Project::create(['name' => 'Project 2', 'price' => 150, 'account_id' => $account1->id]);
        $project3 = Project::create(['name' => 'Project 3', 'price' => 80, 'account_id' => $account2->id]);

        $job1 = Job::create(['name' => 'Job 1', 'amount' => 1000, 'project_id' => $project1->id]);
        $job2 = Job::create(['name' => 'Job 2', 'amount' => 2000, 'project_id' => $project1->id]);
        $job3 = Job::create(['name' => 'Job 3', 'amount' => 1500, 'project_id' => $project2->id]);

        Task::create(['name' => 'Task 1', 'job_id' => $job1->id]);
        Task::create(['name' => 'Task 2', 'job_id' => $job1->id]);
        Task::create(['name' => 'Task 3', 'job_id' => $job2->id]);
        Task::create(['name' => 'Task 4', 'job_id' => $job3->id]);
    }
}
