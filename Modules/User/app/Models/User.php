<?php

namespace Modules\User\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Modules\Task\Models\Task;
use Modules\WorkSession\Models\WorkSession;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, InteractsWithMedia, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'specialization',
        'framework',
        'is_blocked',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Get the user's profile photo URL.
     * If the user has a stored media image, return its accessible URL.
     * Otherwise, return a default avatar with the user's first name letter.
     */
    public function getProfilePhotoUrlAttribute()
    {
        // Check if the user has a media image via Spatie Media Library
        $media = $this->getFirstMedia();

        if ($media) {
            // Return a route that serves the stored image securely
            return route('user.image', ['media' => $media->id]);
        }

        // If no media is found, generate a default avatar using the first letter of the name
        $firstLetter = strtoupper(mb_substr($this->name, 0, 1));
        $name = urlencode($firstLetter);

        return "https://ui-avatars.com/api/?name={$name}&background=0D8ABC&color=fff&size=256";
    }

    public function tasks()
    {
        return $this->belongsToMany(
            Task::class,
            'task_assignments',
            'developer_id',
            'task_id'
        )
            ->withPivot('status', 'reject_reason')
            ->withTimestamps();
    }

    // Returns the latest active work session (where end_time is null) for the developer.
    public function activeWorkSession()
    {
        return $this->hasOne(WorkSession::class, 'developer_id')
            ->whereNull('end_time')
            ->latest();
    }

    // Scope to get all unblocked developers.
    public function scopeUnblockedDevelopers($query)
    {
        return $query->role('developer')->where('is_blocked', 0);
    }

    // Count today's candidate tasks assigned to the current developer
    public function todayCandidateTasksCount()
    {
        return DB::table('task_assignments')
            ->where('developer_id', $this->id)
            ->where('status', 'candidate')
            ->whereDate('created_at', Carbon::today())
            ->count();
    }
}
