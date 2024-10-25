<?php

namespace Database\Seeders;

use App\Models\GameSession;
use Illuminate\Database\Seeder;

class GameSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GameSession::factory()->count(10)->create();
    }
}
