<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStatusRequest extends FormRequest
{
    public function rules()
    {
        $taskStattus = $this->route('task_status');
        if ($taskStattus) {
            return [
                'name' => 'required|unique:task_statuses,name,' . $taskStattus->id,
            ];
        }

        return [
            'name' => 'required|unique:task_statuses',
        ];
    }
}
