<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Label;
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
        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user)->get(route('labels.create'));
        $response->assertOk();
    }

    public function testStore()
    {
        $labelData = factory(Label::class)->make()->toArray();
        $labelAttrs = \Arr::only($labelData, ['name']);
        $response = $this->actingAs($this->user)->post(route('labels.store'), $labelAttrs);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('labels', $labelAttrs);
    }

    public function testEdit()
    {
        $label = factory(Label::class)->create();
        $response = $this->actingAs($this->user)->get(route('labels.edit', $label));
        $response->assertOk();
    }

    public function testUpdate()
    {
        $label = factory(Label::class)->create();
        $labelData = factory(Label::class)->make()->toArray();
        $data = \Arr::only($labelData, ['name']);
        $response = $this->actingAs($this->user)->patch(route('labels.update', $label), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('labels', $data);
    }

    public function testDestroy()
    {
        $label = factory(Label::class)->create();
        $response = $this->actingAs($this->user)->delete(route('labels.destroy', $label));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }
}
