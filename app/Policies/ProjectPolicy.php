<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    // admin skip semua cek di bawah
    public function before(User $user, string $ability): bool|null
    {
        if ($user->is_admin) {
            return true;
        }
        return null;
    }

    // semua user yang sudah login boleh lihat daftar & detail project
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Project $project): bool
    {
        return true;
    }

    // semua user yang sudah login boleh create project
    public function create(User $user): bool
    {
        return true;
    }

    // cuma owner yang boleh edit/hapus
    public function update(User $user, Project $project): bool
    {
        return $project->isOwner($user);
    }

    public function delete(User $user, Project $project): bool
    {
        return $project->isOwner($user);
    }
}
