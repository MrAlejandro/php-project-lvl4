@include('shared.errors')

<div class="form-group">
    {{ Form::label('name', __('view.task.form.name')) }}
    {{ Form::text('name', $task->name, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    {{ Form::label('description', __('view.task.form.description')) }}
    {{ Form::textarea('description', $task->description, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    {{ Form::label('status_id', __('view.task.form.status')) }}
    {{ Form::select('status_id', $taskStatuses->pluck('name', 'id')->prepend(__('view.task.form.status'), ''), optional($task->status)->id, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    {{ Form::label('label_ids[]', __('view.task.form.labels')) }}
    {{ Form::select('label_ids[]', $labels->pluck('name', 'id'), optional($task->labels)->pluck('id'), ['class' => 'form-control', 'multiple' => true]) }}
</div>

<div class="form-group">
    {{ Form::label('assigned_to_id', __('view.task.form.assignee')) }}
    {{ Form::select('assigned_to_id', $users->pluck('name', 'id')->prepend(__('view.task.form.assignee'), ''), optional($task->assignee)->id, ['class' => 'form-control']) }}
</div>
