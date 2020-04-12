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
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user)->get(route('tasks.create'));
        $response->assertStatus(200);
    }

    public function testCreateFailsForNonAuthenticatedUser()
    {
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(403);
    }

    public function testStore()
    {
        $taskData = factory(Task::class)->make()->toArray();
        $taskStatus = factory(TaskStatus::class)->create();
        $labels = factory(Label::class, 2)->create();
        $assignee = factory(User::class)->create();
        $taskAttrs = collect($taskData)->only(['name', 'description'])
                                  ->merge(['assigned_to_id' => $assignee->id, 'status_id' => $taskStatus->id]);

        $params = $taskAttrs->merge(['label_ids' => $labels->pluck('id')])->toArray();

        $response = $this->actingAs($this->user)->post(route('tasks.store'), $params);
        $response->assertStatus(302);

        $taskAttrs['created_by_id'] = $this->user->id;

        $this->assertDatabaseHas('tasks', $taskAttrs->toArray());
        $this->assertDatabaseHas('task_label', ['label_id' => $labels->first()->id]);
        $this->assertDatabaseHas('task_label', ['label_id' => $labels->last()->id]);
    }

    public function testStoreFailsForNonAuthenticatedUser()
    {
        $response = $this->post(route('tasks.store'), []);
        $response->assertStatus(403);
    }

    public function testShow()
    {
        $response = $this->get(route('tasks.show', $this->tasks->first()));
        $response->assertStatus(200);
    }

    public function testEdit()
    {
        $response = $this->actingAs($this->user)->get(route('tasks.edit', $this->tasks->first()));
        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $taskData = factory(Task::class)->make()->toArray();
        $taskStatus = factory(TaskStatus::class)->create();
        $labels = factory(Label::class, 2)->create();
        $assignee = factory(User::class)->create();
        $taskAttrs = collect($taskData)->only(['name', 'description'])
                                  ->merge(['assigned_to_id' => $assignee->id, 'status_id' => $taskStatus->id]);

        $params = $taskAttrs->merge(['label_ids' => $labels->pluck('id')])->toArray();
        $task = $this->tasks->first();

        $response = $this->actingAs($this->user)->patch(route('tasks.update', $task->id), $params);
        $response->assertStatus(302);

        $this->assertDatabaseHas('tasks', $taskAttrs->toArray());
        $this->assertDatabaseHas('task_label', ['task_id' => $task->id, 'label_id' => $labels->first()->id]);
        $this->assertDatabaseHas('task_label', ['task_id' => $task->id, 'label_id' => $labels->last()->id]);
    }

    public function testUpdateFailsForNotAuthenticatedUser()
    {
        $response = $this->patch(route('tasks.update', $this->tasks->first()), []);
        $response->assertStatus(403);
    }


    public function testDestroy()
    {
        $task = $this->tasks->first();
        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function testDestroyFailsDeletingNotOwnedTask()
    {
        $task = $this->tasks->first();
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));
        $response->assertStatus(403);

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}
