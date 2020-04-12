<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Task;
use App\User;

class TaskPersistenceService
{
    public static function save(Task $task, array $validatedData)
    {
        [$taskAttrs, $labelIds] = self::prepareTaskData($validatedData);

        DB::transaction(function () use ($task, $taskAttrs, $labelIds) {
            $task->update($taskAttrs);
            $task->labels()->sync($labelIds);
        });
    }

    public static function create(User $user, array $validatedData)
    {
        [$taskAttrs, $labelIds] = self::prepareTaskData($validatedData);

        DB::transaction(function () use ($user, $taskAttrs, $labelIds) {
            $task = $user->createdTasks()->create($taskAttrs);
            $task->labels()->sync($labelIds);
        });
    }

    protected static function prepareTaskData(array $validatedData)
    {
        $data = collect($validatedData);
        $labelIds = $data->get('label_ids', []);
        $taskAttrs = $data->except('label_ids')->toArray();

        return [$taskAttrs, $labelIds];
    }
}
