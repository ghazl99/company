<?php

namespace Modules\User\Observers;

use Modules\ActivityLog\Traits\ActivityLogsTrait;
use Modules\User\Models\User;

class UserObserver
{
    use ActivityLogsTrait;

    protected function activityArray(User $user)
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'is_blocked' => $user->is_blocked ? 'محظور' : 'فعال',
            'specialization' => $user->specialization,
            'framework' => $user->framework,
            'photo' => $user->hasMedia('personal_photo')
                ? route('user.image', $user->getFirstMedia('personal_photo')->id)
                : null,
            'cv' => $user->hasMedia('cv')
                ? route('user.cv', $user->getFirstMedia('cv')->id)
                : null,
        ];
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user)
    {
        $this->ActivityLogCreate(
            $this->activityArray($user),
            'تم إنشاء مطور/ة جديد '.$user->name,
            'Create',
            $user
        );
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user)
    {
        // Get the original attributes before the update
        $originalAttributes = $user->getOriginal();
        $originalUser = new User($originalAttributes);

        $oldData = $this->activityArray($originalUser);
        $newData = $this->activityArray($user);

        $this->ActivityLogUpdate(
            $user,
            $oldData,
            $newData,
            'تم تحديث بيانات المطور/ة '.$user->name
        );
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user)
    {
        $this->ActivityLogCreate(
            $this->activityArray($user),
            'تم حذف المطور/ة '.$user->name,
            'Delete',
            $user
        );
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void {}

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void {}
}
