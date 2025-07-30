<?php

namespace Modules\WorkSession\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;

// use Modules\WorkSession\Database\Factories\WorkSessionFactory;

class WorkSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['developer_id', 'start_time', 'end_time', 'duration_seconds'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }
}
