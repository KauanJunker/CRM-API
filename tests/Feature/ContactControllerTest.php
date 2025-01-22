<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $seed;

    public function test_it_can_create_new_contact(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson("api/v1/contact",[
            "name" => "teste01",
            "email" => "test@gmail.com",
            "phone" => "999999999",
            "associated_company" => "company",
            "user_id" => 2
        ]);

        $response->assertStatus(201);
    }

    public function test_it_can_list_all_contacts():void 
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $contact = Contact::factory()->count(5)->create();
        $response = $this->getJson("api/v1/contact");
        $response->assertJsonCount(5);
    }

    public function test_it_cat_update_a_contact()
    {   
        $user = User::factory()->create();
        $this->actingAs($user);

        $contact = Contact::factory()->create([
            'name' => 'John Doe',
            'associated_company' => 'zerobyte'
        ]);

        $updateData = [
            'name' => 'Novo nome',
            'email' => $contact->email,
            'associated_company' => 'Nova empresa'
        ];

        $response = $this->put("api/v1/contact/{$contact->id}", $updateData);
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Novo nome',
        ]);
    }

    public function test_it_can_delete_a_contact()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $contact = Contact::factory()->create();

        $response = $this->delete("api/v1/contact/{$contact->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }

    public function test_it_returns_404_if_contact_not_found_for_update()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->patch("api/v1/contact/999", ['name' => 'Updated Name']);

        $response->assertStatus(404);
    }

    public function test_it_returns_404_if_contact_not_found_for_delete()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete("api/v1/contact/999");

        $response->assertStatus(404);
    }

}
