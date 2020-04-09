<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\TaskStatus;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        factory(TaskStatus::class, 2)->create();
        $response = $this->get(route('task_statuses.index'));
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $taksStatus = factory(TaskStatus::class)->create();
        $response = $this->get(route('task_statuses.show', $taksStatus));
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $response = $this->withoutExceptionHandling()->get(route('task_statuses.create'));
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $factoryData = factory(TaskStatus::class)->make()->toArray();
        $data = \Arr::only($factoryData, ['name']);
        $response = $this->post(route('task_statuses.store'), $data);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testEdit()
    {
        $taskStatus = factory(TaskStatus::class)->create();
        $response = $this->get(route('task_statuses.edit', $taskStatus));
        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $taskStatus = factory(TaskStatus::class)->create();
        $data = ['name' => 'in_qa'];
        $response = $this->patch(route('task_statuses.update', $taskStatus), $data);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testDestroy()
    {
        $taskStatus = factory(TaskStatus::class)->create();
        $response = $this->delete(route('task_statuses.destroy', $taskStatus));
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $this->assertDatabaseMissing('task_statuses', ['id' => $taskStatus->id]);
    }
}
