<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Task;
use App\TaskStatus;
use App\User;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $nonOwnerUser;
    protected $user;
    protected $task;
    protected $taskStatus;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->taskStatus = factory(TaskStatus::class)->create();
        $this->tasks = factory(Task::class, 2)->create(
            ['created_by_id' => $this->user, 'status_id' => $this->taskStatus]
        );
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
        $assignee = factory(User::class)->create();
        $data = collect($taskData)->only(['name', 'description'])
                                  ->merge(['assigned_to_id' => $assignee->id, 'status_id' => $taskStatus->id])
                                  ->toArray();

        $response = $this->actingAs($this->user)->post(route('tasks.store'), $data);
        $response->assertStatus(302);

        $data['created_by_id'] = $this->user->id;

        $this->assertDatabaseHas('tasks', $data);
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
        $assignee = factory(User::class)->create();
        $data = collect($taskData)->only(['name', 'description'])
                                  ->merge(['assigned_to_id' => $assignee->id, 'status_id' => $taskStatus->id])
                                  ->toArray();

        $response = $this->actingAs($this->user)->patch(route('tasks.update', $this->tasks->first()), $data);
        $response->assertStatus(302);

        $this->assertDatabaseHas('tasks', $data);
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
