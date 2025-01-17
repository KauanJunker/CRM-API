<?php

namespace Database\Seeders;

use App\Models\Lead;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lead::create([
            "name" => "isac Chaves",
            "email" => "isac@gmail.com",
            "phone" => "999089203",
            "status" => "em negociação",
            "user_id" => 2
        ]);
        Lead::create([   "name" => "Zequinha Nunes",
            "email" => "zequinha@gmail.com",
            "phone" => "999999999",
            "status" => "novo",
            "user_id" => 2
        ]);
        Lead::create([   "name" => "Murilo Lima",
            "email" => "murilo@gmail.com",
            "phone" => "999999999",
            "status" => "novo",
            "user_id" => 2
        ]);
    }
}
