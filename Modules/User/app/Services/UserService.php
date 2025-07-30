<?php

namespace Modules\User\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Modules\ActivityLog\Traits\ActivityLogsTrait;
use Modules\User\Models\User;
use Modules\User\Repositories\UserRepository;

class UserService
{
    use ActivityLogsTrait;

    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function createUser(array $data): mixed
    {
        return DB::transaction(function () use ($data) {
            $photo = $data['personal_photo'] ?? null;
            $cv = $data['cv'] ?? null;

            unset($data['personal_photo'], $data['cv']);
            // Manually hash the password (instead of relying on mutator)
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);

            $user = $this->userRepository->store($data);

            if ($photo instanceof UploadedFile) {
                $user->addMedia($photo)
                    ->toMediaCollection('personal_photo', 'private');
            }

            if ($cv instanceof UploadedFile) {
                $user->addMedia($cv)
                    ->toMediaCollection('cv', 'private');
            }
            $this->ActivityLogCreate(
                $this->activityArray($user),
                'تم إنشاء مطور/ة جديد '.$user->name,
                'Create',
                $user
            );

            return $user;
        });
    }

    public function update(array $data, $user)
    {
        return DB::transaction(function () use ($data, $user) {
            $oldData = $this->activityArray($user);
            $photo = $data['personal_photo'] ?? null;
            $cv = $data['cv'] ?? null;

            unset($data['personal_photo'], $data['cv']);

            $user = $this->userRepository->update($data, $user);

            if ($photo instanceof UploadedFile) {
                $user->clearMediaCollection('personal_photo');
                $user->addMedia($photo)->toMediaCollection('personal_photo', 'private');
            }

            if ($cv instanceof UploadedFile) {
                $user->clearMediaCollection('cv');
                $user->addMedia($cv)->toMediaCollection('cv', 'private');
            }
            $user->refresh();

            $newData = $this->activityArray($user);
            $this->ActivityLogCreate(
                ['old' => $oldData, 'new' => $newData],
                'تم تحديث بيانات المطور/ة '.$user->name,
                'Update',
                $user
            );
            $this->ActivityLogUpdate(
                $user,
                $oldData,
                $newData,
                'تم تحديث بيانات المطور/ة '.$user->name
            );

            return $user;
        });
    }

    public function logLogin(User $user)
    {
        $user->update(['last_login_at' => now()]);

        $this->ActivityLogCreate(
            ['email' => $user->email],
            'قام/ت '.$user->name.'تسجل الدخول',
            'تسجيل الدخول',
            $user
        );
    }

    protected function activityArray($user)
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
}
