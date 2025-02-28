<?php

namespace Tests\Feature;

use App\Enum\TaskStatus;
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

    public function test_update_task_with_valid_data()
    {
        $task = Task::factory()->create();

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Task',
            'status' => TaskStatus::IN_PROGRESS->value,
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'Updated Task',
                'status' => TaskStatus::IN_PROGRESS->value,
            ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Task',
            'status' => TaskStatus::IN_PROGRESS->value,
        ]);
    }

    public function test_validation_on_update_task()
    {
        $task = Task::factory()->create();

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => '',
            'status' => 'invalid_status',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'status']);
    }

    public function test_update_non_existing_task()
    {
        $response = $this->put('/api/tasks/1', [
            'title' => 'Updated Task',
            'description' => 'Updated Description',
        ]);

        $response->assertStatus(404)
            ->assertJsonFragment([
                'message' => 'Task not found',
            ]);
    }

    public function test_get_tasks_with_status_filter()
    {
        Task::factory()->create(['status' => TaskStatus::PENDING->value]);
        Task::factory()->create(['status' => TaskStatus::COMPLETED->value]);

        $response = $this->getJson('/api/tasks?status=pending');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment(['status' => TaskStatus::PENDING->value]);
    }

    public function test_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson('/api/tasks/'.$task->id);

        $response->assertStatus(204);
    }

    public function test_delete_non_existing_task()
    {
        $response = $this->deleteJson('/api/tasks/1');

        $response->assertStatus(404)
            ->assertJsonFragment([
                'message' => 'Task not found',
            ]);
    }
}

