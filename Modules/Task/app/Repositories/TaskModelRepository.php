<?php

namespace Modules\Task\Repositories;

use Modules\Task\Models\Task;
use Modules\User\Models\User;

class TaskModelRepository implements TaskRepository
{
    public function getAllTasks($user)
    {
        if ($user->hasRole('superAdmin')) {
            return Task::with('developers')->paginate(20);
        } else {
            return $user->tasks()
                ->wherePivotNotIn('status', ['done', 'expired'])
                ->paginate(20);
        }
    }

    public function store(array $data): mixed
    {
        return Task::create($data);
    }

    public function changeDeveloperStatus(Task $task, User $developer, string $status): void
    {
        if ($status === 'rejected') {
            $task->developers()->updateExistingPivot($developer->id, ['status' => 'rejected']);
        } elseif ($status === 'in_progress') {
            $task->developers()->updateExistingPivot($developer->id, ['status' => 'in_progress']);
            $task->update(['status' => 'accepted']);
            // باقي المطورين
            $task->developers()
                ->wherePivot('developer_id', '!=', $developer->id)
                ->update(['task_assignments.status' => 'expired']);
        } elseif ($status === 'done') {
            $task->developers()->updateExistingPivot($developer->id, ['status' => 'done']);
            $task->update(['status' => 'complete']);
        }
    }
}
