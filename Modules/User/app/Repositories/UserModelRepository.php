<?php

namespace Modules\User\Repositories;

use Modules\User\Models\User;

class UserModelRepository implements UserRepository
{
    public function getAllDevelopers(): mixed
    {
        return User::role('developer')->with('activeWorkSession')->get();
    }

    public function store(array $data): mixed
    {
        $user = User::create($data);
        $user->assignRole('developer');

        return $user;
    }

    public function getActiveDevelopers()
    {
        return User::role('developer')->where('is_blocked', 0)
            ->get();
    }

    public function update(array $data, $user)
    {

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'specialization' => $data['specialization'] ?? null,
            'framework' => $data['framework'] ?? null,
            'is_blocked' => isset($data['is_blocked']),
        ]);

        return $user;
    }
}
