<?php

namespace Tests\Feature;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_registration_fails_with_admin_role() 
    {
        $response = $this->postJson('api/v1/register', [
            'name' => 'jose',
            'email' => 'validd@email.com',
            'password' => 'password',
            'c_password' => 'password',
            'role_id' => Role::ROLE_ADMINISTRADOR
        ]);

        $response->assertStatus(422);
    }

    public function test_registration_succeeds_with_equipe_de_vendas_role() 
    {
        $response = $this->postJson('api/v1/register', [
            'name' => 'jose',
            'email' => 'validdd@email.com',
            'password' => 'password',
            'c_password' => 'password',
            'role_id' => Role::ROLE_EQUIPE_VENDAS,
        ]);

        $response->assertStatus(200)->assertJsonStructure(['access_token']);
    }

    public function test_registration_succeeds_with_cliente_role() 
    {
        $response = $this->postJson('api/v1/register', [
            'name' => 'jose',
            'email' => 'validddd@email.com',
            'password' => 'password',
            'c_password' => 'password',
            'role_id' => Role::ROLE_CLIENTE
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'access_token'
        ]);
    }
}
