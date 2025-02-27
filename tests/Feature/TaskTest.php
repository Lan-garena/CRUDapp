<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_task_with_valid_data()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Test Task',
            'status' => 'pending',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'Test Task', 'status' => 'pending']);
    }

    public function test_validation_on_create_task()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => null,
            'status' => 'invalid_status',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['title', 'status']);
    }

    public function test_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson('/api/tasks/'.$task->id);

        $response->assertStatus(204);
    }
}

