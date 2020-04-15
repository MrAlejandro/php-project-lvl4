<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\TaskStatus;
use App\Task;
use App\User;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function testIndex()
    {
        factory(TaskStatus::class, 2)->create();
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testStore()
    {
        $taskStatusData = factory(TaskStatus::class)->make()->toArray();
        $data = \Arr::only($taskStatusData, ['name']);
        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testEdit()
    {
        $taskStatus = factory(TaskStatus::class)->create();
        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', $taskStatus));
        $response->assertOk();
    }

    public function testUpdate()
    {
        $taskStatus = factory(TaskStatus::class)->create();
        $taskStatusData = factory(TaskStatus::class)->make()->toArray();
        $data = \Arr::only($taskStatusData, ['name']);
        $response = $this->actingAs($this->user)->patch(route('task_statuses.update', $taskStatus), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testDestroy()
    {
        $taskStatus = factory(TaskStatus::class)->create();
        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', $taskStatus));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('task_statuses', ['id' => $taskStatus->id]);
    }

    public function testDestroyFailsDeletingStatusAssociatedWithTask()
    {
        $task = factory(Task::class)->create();
        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', $task->status));
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', ['id' => $task->status->id]);
    }
}
