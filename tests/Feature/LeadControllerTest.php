<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeadControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $seed;

    public function test_it_can_create_new_lead(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson("api/v1/lead",[
            "name" => "zequi Chaves",
            "email" => "zequinhanunes2@gmail.com",
            "phone" => "999089302",
            "status" => "em negociação",
            "user_id" => 2
        ]);

        $response->assertStatus(201);
    }

    public function test_it_can_list_all_leads():void 
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $lead = Lead::factory()->count(2)->create();
        $response = $this->getJson("api/v1/lead");
        $response->assertJsonCount(5);
    }

    public function test_it_cat_update_a_lead()
    {   
        $user = User::factory()->create();
        $this->actingAs($user);

        $lead = Lead::factory()->create([
            'name' => 'John Doe',
            'status' => 'fechado'
        ]);

        $updateData = [
            'name' => 'Novo nome',
            'status' =>  'em negociação',
            'email'=> $lead->email,
            'phone'=> $lead->phone,
        ];

        $response = $this->put("api/v1/lead/{$lead->id}", $updateData);
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('leads', [
            'id' => $lead->id,
            'name' => 'Novo nome',
            'status' => 'em negociação',
        ]);
    }

    public function test_it_can_delete_a_lead()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $lead = Lead::factory()->create();

        $response = $this->delete("api/v1/lead/{$lead->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('leads', [
            'id' => $lead->id,
        ]);
    }

    public function test_it_returns_404_if_lead_not_found_for_update()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->patch("api/v1/lead/999", ['name' => 'Updated Name']);

        $response->assertStatus(404);
    }

    public function test_it_returns_404_if_lead_not_found_for_delete()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete("api/v1/lead/999");

        $response->assertStatus(404);
    }
}
