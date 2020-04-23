<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Task;

class TaskService
{
    public static function update(Task $task, array $validatedData)
    {
        [$taskAttrs, $labelIds] = self::prepareTaskData($validatedData);

        DB::transaction(function () use ($task, $taskAttrs, $labelIds) {
            $task->update($taskAttrs);
            $task->labels()->sync($labelIds);
        });

        return $task;
    }

    public static function store(Task $task, array $validatedData)
    {
        [$taskAttrs, $labelIds] = self::prepareTaskData($validatedData);

        $task = DB::transaction(function () use ($task, $taskAttrs, $labelIds) {
            $task->fill($taskAttrs)->save();
            $task->labels()->sync($labelIds);

            return $task;
        });

        return $task;
    }

    protected static function prepareTaskData(array $validatedData)
    {
        $data = collect($validatedData);
        $labelIds = $data->get('label_ids', []);
        $taskAttrs = $data->except('label_ids')->toArray();

        return [$taskAttrs, $labelIds];
    }
}
