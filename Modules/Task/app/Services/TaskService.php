<?php

namespace Modules\Task\Services;

use Illuminate\Support\Facades\DB;
use Modules\Task\Models\Task;
use Modules\Task\Repositories\TaskRepository;
use Modules\User\Models\User;

class TaskService
{
    public function __construct(
        protected TaskRepository $taskRepository
    ) {}

    public function getAllTasks($user)
    {
        return $this->taskRepository->getAllTasks($user);
    }

    public function changeStatus(Task $task, User $developer, string $status): void
    {
        $this->taskRepository->changeDeveloperStatus($task, $developer, $status);
    }

    public function createTaskWithDevelopers(array $data)
    {
        return DB::transaction(function () use ($data) {
            $task = $this->taskRepository->store($data);
            $task->developers()->attach($data['developers']);
            if (isset($data['images'])) {
                $task->addMultipleMediaFromRequest(['images'])
                    ->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('tasks', 'private');
                    });
            }

            return $task;
        });
    }
}
