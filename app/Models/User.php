<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- Relations ---

    // project yang dia buat sendiri
    public function ownedProjects()
    {
        return $this->hasMany(Project::class, 'owner_id');
    }

    // project yang dia ikuti sebagai member
    public function memberProjects()
    {
        return $this->belongsToMany(Project::class, 'project_members');
    }

    // task yang di-assign ke dia
    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
