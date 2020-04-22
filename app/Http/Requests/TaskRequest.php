<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'name' => 'required|unique:tasks',
            'description' => 'string|nullable',
            'status_id' => 'required|numeric',
            'assigned_to_id' => 'integer|nullable',
            'label_ids' => 'array|nullable',
        ];

        $task = $this->route('task');
        if ($task) {
            $rules['name'] = 'required|unique:tasks,name,' . $task->id;
        }

        return $rules;
    }
}
