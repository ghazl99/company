<?php

namespace Modules\Task\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// use Modules\Task\Database\Factories\TaskFactory;

class Task extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'estimated_hours',
        'status',
    ];

    public function developers()
    {
        return $this->belongsToMany(
            User::class,
            'task_assignments',
            'task_id',
            'developer_id'
        )
            ->withPivot('status', 'reject_reason')
            ->withTimestamps();
    }
}
