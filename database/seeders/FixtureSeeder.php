<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fixture;

class FixtureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fixtures = [
            // Upcoming matches
            [
                'opponent' => 'Maziya S&RC',
                'match_date' => now()->addDays(7),
                'match_time' => '16:00',
                'venue' => 'Rasmee Dhandu Stadium',
                'type' => 'home',
                'competition' => 'First Division',
                'age_group' => 'Senior',
                'status' => 'scheduled',
            ],
            [
                'opponent' => 'Eagles FC',
                'match_date' => now()->addDays(14),
                'match_time' => '18:30',
                'venue' => 'Eagles Ground',
                'type' => 'away',
                'competition' => 'First Division',
                'age_group' => 'Senior',
                'status' => 'scheduled',
            ],
            [
                'opponent' => 'Valencia FC',
                'match_date' => now()->addDays(21),
                'match_time' => '16:00',
                'venue' => 'Rasmee Dhandu Stadium',
                'type' => 'home',
                'competition' => 'First Division',
                'age_group' => 'Senior',
                'status' => 'scheduled',
            ],
            // Academy matches
            [
                'opponent' => 'Youth Academy FC',
                'match_date' => now()->addDays(3),
                'match_time' => '15:00',
                'venue' => 'Rasmee Dhandu Stadium',
                'type' => 'home',
                'competition' => 'Youth League',
                'age_group' => 'U16',
                'status' => 'scheduled',
            ],
            [
                'opponent' => 'Future Stars FC',
                'match_date' => now()->addDays(10),
                'match_time' => '14:00',
                'venue' => 'Future Stars Ground',
                'type' => 'away',
                'competition' => 'Youth League',
                'age_group' => 'U14',
                'status' => 'scheduled',
            ],
            // Recent results
            [
                'opponent' => 'Victory FC',
                'match_date' => now()->subDays(3),
                'match_time' => '16:00',
                'venue' => 'Rasmee Dhandu Stadium',
                'type' => 'home',
                'competition' => 'First Division',
                'age_group' => 'Senior',
                'our_score' => 2,
                'opponent_score' => 1,
                'status' => 'completed',
            ],
            [
                'opponent' => 'United FC',
                'match_date' => now()->subDays(7),
                'match_time' => '18:30',
                'venue' => 'United Ground',
                'type' => 'away',
                'competition' => 'First Division',
                'age_group' => 'Senior',
                'our_score' => 1,
                'opponent_score' => 3,
                'status' => 'completed',
            ],
            [
                'opponent' => 'Champions Academy',
                'match_date' => now()->subDays(5),
                'match_time' => '15:00',
                'venue' => 'Rasmee Dhandu Stadium',
                'type' => 'home',
                'competition' => 'Youth League',
                'age_group' => 'U16',
                'our_score' => 4,
                'opponent_score' => 0,
                'status' => 'completed',
            ],
            [
                'opponent' => 'Rising Stars FC',
                'match_date' => now()->subDays(10),
                'match_time' => '14:00',
                'venue' => 'Rising Stars Ground',
                'type' => 'away',
                'competition' => 'Youth League',
                'age_group' => 'U14',
                'our_score' => 2,
                'opponent_score' => 2,
                'status' => 'completed',
            ],
        ];

        foreach ($fixtures as $fixture) {
            Fixture::create($fixture);
        }
    }
}
