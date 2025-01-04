<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function create(User $user)
    {
        return $user->role === 'manager';
    }

    public function update(User $user, Task $task)
    {
        if ($user->role === 'manager') {
            return true;
        }

        return $user->id === $task->user_id && $user->role === 'user';
    }

    public function view(User $user, Task $task)
    {
        return $user->role === 'manager' || $user->id === $task->user_id;
    }
}

