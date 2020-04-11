<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Label;
use App\Task;
use App\User;

class LabelsControllerTest extends TestCase
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
        factory(Label::class, 2)->create();
        $response = $this->get(route('labels.index'));
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user)->get(route('labels.create'));
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $labelData = factory(Label::class)->make()->toArray();
        $data = \Arr::only($labelData, ['name']);
        $response = $this->actingAs($this->user)->post(route('labels.store'), $data);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $this->assertDatabaseHas('labels', $data);
    }

    public function testEdit()
    {
        $label = factory(Label::class)->create();
        $response = $this->actingAs($this->user)->get(route('labels.edit', $label));
        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $label = factory(Label::class)->create();
        $labelData = factory(Label::class)->make()->toArray();
        $data = \Arr::only($labelData, ['name']);
        $response = $this->actingAs($this->user)->patch(route('labels.update', $label), $data);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $this->assertDatabaseHas('labels', $data);
    }

    public function testDestroy()
    {
        $label = factory(Label::class)->create();
        $response = $this->actingAs($this->user)->delete(route('labels.destroy', $label));
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }

    public function testDestroyFailsDeletingLabelAssociatedWithTask()
    {
        $label = factory(Label::class)->create();
        $task = factory(Task::class)->create();
        $task->labels()->save($label);
        $response = $this->actingAs($this->user)->delete(route('labels.destroy', $label));
        $response->assertStatus(302);

        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }
}
