<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'assigned_to',
        'title',
        'description',
        'status',   // todo | in_progress | done
        'priority', // low | medium | high
        'deadline', // boleh kosong kalau tidak ada deadline
    ];

    protected $casts = [
        'deadline' => 'date', // jadi Carbon instance saat diakses
    ];

    // --- Relations ---

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // user yang mengerjakan task ini
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}