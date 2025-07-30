<?php

namespace Modules\Task\Repositories;

use Modules\Task\Models\Task;
use Modules\User\Models\User;

interface TaskRepository
{
    public function getAllTasks($user);

    public function store(array $data): mixed;

    public function changeDeveloperStatus(Task $task, User $developer, string $status): void;
}
