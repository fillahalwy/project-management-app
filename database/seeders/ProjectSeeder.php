<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $admin   = User::where('email', 'atmin@mail.com')->first();
        $member1 = User::where('email', 'member1@mail.com')->first();
        $member2 = User::where('email', 'member2@mail.com')->first();

        $project1 = Project::create([
            'name'        => 'UI/UX Website',
            'description' => 'UI/UX website perusahaan',
            'status'      => 'active',
            'owner_id'    => $admin->id,
        ]);

        // Attach members ke project
        $project1->members()->attach([$member1->id, $member2->id]);

        // Buat tasks untuk project1
        Task::create([
            'project_id'  => $project1->id,
            'assigned_to' => $member1->id,
            'title'       => 'Wirefreame homepage',
            'status'      => 'done',
            'priority'    => 'high',
        ]);

        Task::create([
            'project_id'  => $project1->id,
            'assigned_to' => $member2->id,
            'title'       => 'Develop homepage',
            'status'      => 'in_progress',
            'priority'    => 'high',
        ]);

        $project2 = Project::create([
            'name'        => 'APJ',
            'description' => 'Aplikasi Pemberantas Judol',
            'status'      => 'active',
            'owner_id'    => $member1->id,
        ]);

        $project2->members()->attach([$member2->id]);

        Task::create([
            'project_id'  => $project2->id,
            'assigned_to' => $member2->id,
            'title'       => 'Setup repo',
            'status'      => 'todo',
            'priority'    => 'medium',
        ]);
    }
}