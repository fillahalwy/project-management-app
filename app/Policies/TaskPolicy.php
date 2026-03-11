<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    // admin skip semua cek di bawah
    public function before(User $user, string $ability): bool|null
    {
        if ($user->is_admin) {
            return true;
        }
        return null;
    }

    public function create(User $user): bool
    {
        return true;
    }

    // owner & member boleh edit task
    public function update(User $user, Task $task): bool
    {
        $project = $task->project;
        return $project->isOwner($user) || $project->isMember($user);
    }

    // hapus task cuma boleh owner project
    public function delete(User $user, Task $task): bool
    {
        $project = $task->project;
        return $project->isOwner($user);
    }
}
