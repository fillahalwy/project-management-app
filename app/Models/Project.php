<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',   // active | on_hold | completed
        'owner_id', // pemilik project
    ];

    // --- Relations ---

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // many-to-many lewat pivot project_members
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // --- Helpers ---

    // cek apakah user ini salah satu member project
    public function isMember(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }

    // cek apakah user ini ownernya
    public function isOwner(User $user): bool
    {
        return (int) $this->owner_id === (int) $user->id;
    }
}