@include('shared.errors')

<div class="form-group">
    <label for="name">{{ __('view.task.form.name') }}</label>
    <input class="form-control" name="name" type="text" value="{{ $task->name }}" id="name">
    @if($errors->has('name'))
        <div class="error">{{ $errors->first('name') }}</div>
    @endif
</div>

<div class="form-group">
    <label for="description">{{ __('view.task.form.description') }}</label>
    <textarea class="form-control" name="description" cols="50" rows="10" id="description">{{ $task->description }}</textarea>
</div>

<div class="form-group">
    <label for="status_id">{{ __('view.task.form.status') }}</label>
    <select class="form-control" id="status_id" name="status_id">
        <option value="">{{ __('view.task.form.status') }}</option>
        @foreach($taskStatuses as $taskStatus)
            <option value="{{ $taskStatus->id }}" {{ ($task->status && $taskStatus->id == $task->status->id) ? "selected" : "" }}>{{ $taskStatus->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="assigned_to_id">{{ __('view.task.form.assignee') }}</label>
    <select class="form-control" id="assigned_to_id" name="assigned_to_id">
        <option value="">{{ __('view.task.form.assignee') }}</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ ($task->assignee && $user->id == $task->assignee->id) ? "selected" : "" }}>{{ $user->name }}</option>
        @endforeach
    </select>
</div>


