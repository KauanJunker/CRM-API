<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipeVendasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "bileide Silva",
            "email" => "bileide@example.com",
            "password" => "senha",
            "email_verified_at" => now(),
            "role_id" => 2 // EQUIPE DE VENDAS
        ]);
    }
}
