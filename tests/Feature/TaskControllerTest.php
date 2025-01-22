<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $seed;

    public function test_it_can_create_new_task(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson("api/v1/task",[
           "title" => "Ligar para cliente",
            "description" => "Ligar para cliente.",
            "due_at" => "2024-02-10 14:30:00",
            "lead_id" => 2,
            "user_id" => 2
        ]);

        $response->assertStatus(201);
    }

    public function test_it_can_list_all_tasks():void 
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $lead = Task::factory()->count(5)->create();
        $response = $this->getJson("api/v1/task");
        $response->assertJsonCount(5);
    }

    public function test_it_cat_update_a_task()
    {   
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create([
            'title' => 'Ligar para cliente',
            'description' => 'Ligar para cliente'
        ]);

        $updateData = [
            'title' => 'Ligar',
            'description' => 'Ligar.'
        ];

        $response = $this->put("api/v1/task/{$task->id}", $updateData);
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Ligar',
        ]);
    }

    public function test_it_can_delete_a_test_it_cat_update_a_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create();

        $response = $this->delete("api/v1/task/{$task->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_it_returns_404_if_task_not_found_for_update()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->patch("api/v1/task/999", ['title' => 'Updated Name']);

        $response->assertStatus(404);
    }

    public function test_it_returns_404_if_task_not_found_for_delete()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete("api/v1/task/999");

        $response->assertStatus(404);
    }

    public function test_it_return_200_when_task_is_finished()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create();

        $response = $this->patch("api/v1/completeTask/{$task->id}");
        $response->assertStatus(200);
    }

    public function test_it_returns_404_if_task_not_found_for_be_finished()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete("api/v1/task/999");

        $response->assertStatus(404);
    }
}
