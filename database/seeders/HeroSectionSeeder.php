<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HeroSection;

class HeroSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $heroSections = [
            [
                'title' => 'New Radiant SC - Pride of Maldivian Football',
                'subtitle' => 'Established 1979',
                'description' => 'Join us in celebrating over four decades of football excellence. From our historic victories to our commitment to youth development, New Radiant continues to be the pride of Maldivian football.',
                'image' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1200&h=600&fit=crop',
                'button_text' => 'Join Our Academy',
                'button_link' => '/academy',
                'type' => 'hero',
                'is_active' => true,
                'sort_order' => 1,
                'published_at' => now(),
            ],
            [
                'title' => 'New Radiant Returns to First Division',
                'subtitle' => 'Historic Comeback After Half a Decade',
                'description' => 'After five years of hard work and determination, New Radiant Sports Club has secured promotion back to the Dhivehi Premier League. This marks a new chapter in our storied history.',
                'image' => 'https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d?w=1200&h=600&fit=crop',
                'button_text' => 'Read More',
                'button_link' => '/news',
                'type' => 'announcement',
                'is_active' => true,
                'sort_order' => 2,
                'published_at' => now(),
            ],
            [
                'title' => 'Academy Registration Now Open',
                'subtitle' => 'Develop Your Skills with the Best',
                'description' => 'Our youth academy is now accepting registrations for the 2024 season. Join our comprehensive training program designed to develop the next generation of Maldivian football stars.',
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=1200&h=600&fit=crop',
                'button_text' => 'Register Now',
                'button_link' => '/academy/enroll',
                'type' => 'promotion',
                'is_active' => true,
                'sort_order' => 3,
                'published_at' => now(),
            ],
            [
                'title' => 'Upcoming Match: New Radiant vs Victory',
                'subtitle' => 'Rasmee Dhandu Stadium',
                'description' => 'Don\'t miss our next home match against Victory SC. Come support the team as we continue our journey in the Dhivehi Premier League.',
                'image' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1200&h=600&fit=crop',
                'button_text' => 'Get Tickets',
                'button_link' => '/fixtures',
                'type' => 'announcement',
                'is_active' => true,
                'sort_order' => 4,
                'published_at' => now(),
                'expires_at' => now()->addDays(7),
            ]
        ];

        foreach ($heroSections as $section) {
            HeroSection::create($section);
        }
    }
}
