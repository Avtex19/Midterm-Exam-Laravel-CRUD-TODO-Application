<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task(): void
    {
        $deadline = now()->addDays(5)->format('Y-m-d');

        $response = $this->post(route('tasks.store'), [
            'title' => 'Prepare final submission',
            'description' => 'Collect project files and export database.',
            'status' => Task::STATUS_PENDING,
            'deadline' => $deadline,
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title' => 'Prepare final submission',
            'status' => Task::STATUS_PENDING,
        ]);
    }

    public function test_user_can_update_task(): void
    {
        $task = Task::factory()->create([
            'title' => 'Old title',
            'status' => Task::STATUS_PENDING,
        ]);

        $deadline = now()->addDays(10)->format('Y-m-d');

        $response = $this->put(route('tasks.update', $task), [
            'title' => 'Updated title',
            'description' => 'Updated description.',
            'status' => Task::STATUS_DONE,
            'deadline' => $deadline,
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated title',
            'status' => Task::STATUS_DONE,
        ]);
    }

    public function test_user_can_delete_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_user_can_filter_tasks_by_status(): void
    {
        $doneTask = Task::factory()->create([
            'title' => 'Done task',
            'status' => Task::STATUS_DONE,
        ]);
        $pendingTask = Task::factory()->create([
            'title' => 'Pending task',
            'status' => Task::STATUS_PENDING,
        ]);

        $response = $this->get(route('tasks.index', ['status' => Task::STATUS_DONE]));

        $response->assertOk();
        $response->assertSee($doneTask->title);
        $response->assertDontSee($pendingTask->title);
    }

    public function test_user_can_toggle_task_status(): void
    {
        $task = Task::factory()->create([
            'status' => Task::STATUS_PENDING,
        ]);

        $response = $this->post(route('tasks.toggle', $task));

        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => Task::STATUS_DONE,
        ]);
    }

    public function test_store_requires_valid_fields(): void
    {
        $response = $this->from(route('tasks.create'))->post(route('tasks.store'), [
            'title' => '',
            'status' => 'invalid-status',
            'deadline' => 'not-a-date',
        ]);

        $response->assertRedirect(route('tasks.create'));
        $response->assertSessionHasErrors(['title', 'status', 'deadline']);
    }

    public function test_update_requires_valid_fields(): void
    {
        $task = Task::factory()->create();

        $response = $this->from(route('tasks.edit', $task))->put(route('tasks.update', $task), [
            'title' => '',
            'status' => 'invalid-status',
            'deadline' => 'not-a-date',
        ]);

        $response->assertRedirect(route('tasks.edit', $task));
        $response->assertSessionHasErrors(['title', 'status', 'deadline']);
    }

    public function test_store_rejects_deadline_in_the_past(): void
    {
        $response = $this->from(route('tasks.create'))->post(route('tasks.store'), [
            'title' => 'Past deadline task',
            'status' => Task::STATUS_PENDING,
            'deadline' => now()->subDay()->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('tasks.create'));
        $response->assertSessionHasErrors('deadline');
    }

    public function test_update_allows_past_deadline_when_unchanged(): void
    {
        $past = now()->subYears(2)->format('Y-m-d');
        $task = Task::factory()->create([
            'deadline' => $past,
        ]);

        $response = $this->put(route('tasks.update', $task), [
            'title' => 'Title updated only',
            'description' => $task->description,
            'status' => $task->status,
            'deadline' => $past,
        ]);

        $response->assertRedirect(route('tasks.index'));
        $task->refresh();
        $this->assertSame('Title updated only', $task->title);
        $this->assertSame($past, $task->deadline->format('Y-m-d'));
    }

    public function test_update_rejects_new_deadline_in_the_past(): void
    {
        $task = Task::factory()->create([
            'deadline' => now()->addMonth()->format('Y-m-d'),
        ]);

        $response = $this->from(route('tasks.edit', $task))->put(route('tasks.update', $task), [
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status,
            'deadline' => now()->subWeek()->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('tasks.edit', $task));
        $response->assertSessionHasErrors('deadline');
    }
}
