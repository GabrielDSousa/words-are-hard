<?php

namespace Database\Seeders;

use App\Models\Upgrade;
use Illuminate\Database\Seeder;

class UpgradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $upgrades = [
            [
                'name' => 'Extra Attempt',
                'description' => 'Grants one extra attempt for the next round.',
                'effect' => json_encode(['attempts_left' => 1]),
            ],
            [
                'name' => 'Permanent Life',
                'description' => 'Adds one permanent life for the current game session.',
                'effect' => json_encode(['lives' => 1]),
            ],
            [
                'name' => 'Double Points',
                'description' => 'Doubles the points for the next round.',
                'effect' => json_encode(['points_multiplier' => 2]),
            ],
            [
                'name' => 'Triple Points',
                'description' => 'Triples the points for the next round.',
                'effect' => json_encode(['points_multiplier' => 3]),
            ],
            [
                'name' => 'Increase Rare Word',
                'description' => 'Have a hard word next round for the double of points',
                'effect' => json_encode(['rare_word_bonus' => true]),
            ],
            [
                'name' => 'Hint Reveal',
                'description' => 'Reveals a hint for the next word.',
                'effect' => json_encode(['hint' => true]),
            ],
            [
                'name' => 'Extra Score Bonus',
                'description' => 'Gives an additional 50 points in the next round.',
                'effect' => json_encode(['extra_points' => 50]),
            ],
            [
                'name' => 'Mystery Bonus',
                'description' => 'Grants a random bonus effect for the next round.',
                'effect' => json_encode(['mystery_bonus' => true]),
            ],
        ];

        foreach ($upgrades as $upgrade) {
            Upgrade::create($upgrade);
        }
    }
}
