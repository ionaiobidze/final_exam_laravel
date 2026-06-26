<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'title'       => 'Submit Web Development Assignment',
                'description' => 'Complete the Laravel CRUD midterm project and upload to the course portal.',
                'status'      => 'pending',
                'deadline'    => now()->addDays(3)->toDateString(),
            ],
            [
                'title'       => 'Read Chapter 4 — Algorithms',
                'description' => 'Cover sorting algorithms and dynamic programming sections before the next lecture.',
                'status'      => 'done',
                'deadline'    => now()->subDays(2)->toDateString(),
            ],
            [
                'title'       => 'Group Project — KIU CS Finals',
                'description' => 'Meet with team to finalize the presentation slides and divide demo responsibilities.',
                'status'      => 'pending',
                'deadline'    => now()->addDays(10)->toDateString(),
            ],
            [
                'title'       => 'Prepare for Database Systems Exam',
                'description' => 'Review normalization, ER diagrams, and SQL joins from lecture notes.',
                'status'      => 'pending',
                'deadline'    => now()->subDay()->toDateString(),
            ],
            [
                'title'       => 'Submit Operating Systems Lab Report',
                'description' => 'Write up the process scheduling experiment results and submit via Moodle.',
                'status'      => 'done',
                'deadline'    => now()->subDays(5)->toDateString(),
            ],
            [
                'title'       => 'Study for Discrete Mathematics Quiz',
                'description' => 'Focus on graph theory and combinatorics chapters.',
                'status'      => 'pending',
                'deadline'    => now()->addDays(1)->toDateString(),
            ],
            [
                'title'       => 'Complete Python Data Analysis Homework',
                'description' => 'Implement pandas-based data cleaning and visualization for the given dataset.',
                'status'      => 'done',
                'deadline'    => now()->subDays(7)->toDateString(),
            ],
            [
                'title'       => 'Review Computer Networks Slides',
                'description' => 'Go over TCP/IP model and subnetting examples before the weekly review session.',
                'status'      => 'pending',
                'deadline'    => now()->subDays(3)->toDateString(),
            ],
            [
                'title'       => 'Attend Career Fair at KIU Campus',
                'description' => 'Bring CV copies and talk to at least three tech companies at the spring fair.',
                'status'      => 'done',
                'deadline'    => now()->subDays(10)->toDateString(),
            ],
            [
                'title'       => 'Write Research Proposal — AI Ethics',
                'description' => 'Draft a 1500-word proposal on bias in machine learning systems for the ethics seminar.',
                'status'      => 'pending',
                'deadline'    => now()->addDays(14)->toDateString(),
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
