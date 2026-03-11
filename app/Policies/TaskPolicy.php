<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        // Jika user adalah admin, berikan akses penuh
        if ($user->is_admin) {
            return true;
        }
        return null;
    }
    
    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Task $task): bool
    {
        $project = $task->project;
        return $project->isOwner($user) || $project->isMember($user);
    }

    public function delete(User $user, Task $task): bool
    {
        $project = $task->project;
        return $project->isOwner($user);
    }
}
