<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppointmentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $seed;

    public function test_it_can_create_new_appointment(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson("api/v1/appointment",[
            "user_id" => 2,
            "lead_id" => 1,
            "appointment_date" => now()->addDay(),
            "notes" => "Reunião",
        ]);

        $response->assertStatus(201);
    }

    public function test_it_can_list_all_appointment():void 
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Appointment::factory()->count(2)->create();
        $response = $this->getJson("api/v1/appointment");
        $response->assertJsonCount(2);
    }

    public function test_it_cat_update_a_appointment()
    {   
        $user = User::factory()->create();
        $this->actingAs($user);

        $appointment = Appointment::factory()->create([
            'notes' => 'Reunião as 15:00'
        ]);

        $updateData = [
            'notes' => 'Reunião'
        ];

        $response = $this->put("api/v1/appointment/{$appointment->id}", $updateData);
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'notes' => 'Reunião'
        ]);
    }

    public function test_it_can_delete_a_appointment()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $appointment = Appointment::factory()->create();

        $response = $this->delete("api/v1/appointment/{$appointment->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('appointments', [
            'id' => $appointment->id,
        ]);
    }

    public function test_it_returns_404_if_appointment_not_found_for_update()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->patch("api/v1/appointment/999", ['notes' => 'Updated notes']);

        $response->assertStatus(404);
    }

    public function test_it_returns_404_if_appointment_not_found_for_delete()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete("api/v1/appointment/999");

        $response->assertStatus(404);
    }
}
