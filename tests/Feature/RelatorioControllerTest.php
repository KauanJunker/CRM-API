<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RelatorioControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $seed;

    public function test_it_can_list_quatity_of_lead_by_status(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Lead::factory()->create(['status' => 'novo']);
        Lead::factory()->create(['status' => 'novo']);
        Lead::factory()->create(['status' => 'fechado']);
        Lead::factory()->create(['status' => 'perdido']);
        Lead::factory()->create(['status' => 'em negociação']);
        Lead::factory()->create(['status' => 'em negociação']);

        $response = $this->getJson('api/v1/quantidadeLeadPorStatus');
        
        $response->assertStatus(200);

        $response->assertJson([
            'Leads novos' => 4, //Colocar 4 invés de 2 pois já contém um seed com 2 leads
            'Leads em negociação' => 3, //Colocar 4 invés de 2 pois já contém um seed com 1 leads
            'Leads fechados' => 1,
            'Leads perdidos' => 1,
        ]);
    }

    public function test_it_can_list_all_pending_tasks()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Task::factory()->create(['done' => false]);
        Task::factory()->create(['done' => true]);

        $response = $this->getJson('api/v1/tarefasPendentes');
        $response->assertStatus(200);

        $responseData = $response->json();
        foreach($responseData as $task) {
            $this->assertFalse($task['done']);
        }
    }

    public function test_it_can_list_all_done_tasks()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Task::factory()->create(['done' => true]);
        Task::factory()->create(['done' => false]);

        $response = $this->getJson('api/v1/tarefasConcluidas');
        $response->assertStatus(200);

        $responseData = $response->json();
        foreach($responseData as $task) {
            $this->assertTrue($task['done']);
        }
    }

    public function test_it_can_list_most_active_leads()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Lead::factory()->hasTasks(5)->create();
        Lead::factory()->hasTasks(2)->create();

        $response = $this->getJson('api/v1/contatosLeadsMaisAtivos');
        $response->assertStatus(200);

        $responseData = $response->json();
        
        foreach($responseData as $lead) {
            $this->assertArrayHasKey('tasks', $lead);
            $this->assertGreaterThanOrEqual(3, $lead['tasks']);
        }
    }
}
