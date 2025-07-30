<?php

namespace Modules\User\Repositories;

interface UserRepository
{
    public function store(array $data): mixed;

    public function getAllDevelopers(): mixed;

    public function getActiveDevelopers();

    public function update(array $data, $id);
}
