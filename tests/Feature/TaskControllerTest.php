<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Task;
use App\TaskStatus;
use App\User;
use App\Label;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $task;
    protected $taskStatus;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->taskStatus = factory(TaskStatus::class)->create();
        $this->tasks = factory(Task::class, 2)->create();

        $this->taskStatus->tasks()->saveMany($this->tasks);
        $this->user->createdTasks()->saveMany($this->tasks);
    }

    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user)->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore()
    {
        $label = factory(Label::class)->create();
        $taskData = factory(Task::class)->make()->toArray();
        $taskAttrs = \Arr::only($taskData, ['name', 'description', 'assigned_to_id', 'status_id']);

        $params = \Arr::add($taskAttrs, 'label_ids', [$label->id]);

        $response = $this->actingAs($this->user)->post(route('tasks.store'), $params);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $taskAttrs['created_by_id'] = $this->user->id;

        $this->assertDatabaseHas('tasks', $taskAttrs);
        $this->assertDatabaseHas('task_label', ['label_id' => $label->id]);
    }

    public function testShow()
    {
        $response = $this->get(route('tasks.show', $this->tasks->first()));
        $response->assertOk();
    }

    public function testEdit()
    {
        $response = $this->actingAs($this->user)->get(route('tasks.edit', $this->tasks->first()));
        $response->assertOk();
    }

    public function testUpdate()
    {
        $label = factory(Label::class)->create();
        $taskData = factory(Task::class)->make()->toArray();
        $taskAttrs = \Arr::only($taskData, ['name', 'description', 'assigned_to_id', 'status_id']);

        $params = \Arr::add($taskAttrs, 'label_ids', [$label->id]);
        $task = $this->tasks->first();

        $response = $this->actingAs($this->user)->patch(route('tasks.update', $task->id), $params);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', $taskAttrs);
        $this->assertDatabaseHas('task_label', ['label_id' => $label->id]);
    }

    public function testDestroy()
    {
        $task = $this->tasks->first();
        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
