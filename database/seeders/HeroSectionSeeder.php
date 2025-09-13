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
                'image' => 'team.jpg',
                'button_text' => 'Join Our Academy',
                'button_link' => '/academy',
                'type' => 'hero',
                'is_active' => true,
                'sort_order' => 1,
                'published_at' => now(),
            ],
            [
                'title' => 'Championship Legacy - Building Future Stars',
                'subtitle' => 'Academy Excellence',
                'description' => 'Our youth academy continues to produce talented players who represent the future of Maldivian football. Join our comprehensive training program designed to develop the next generation of champions.',
                'image' => 'champ.jpg',
                'button_text' => 'View First Team',
                'button_link' => '/first-team',
                'type' => 'announcement',
                'is_active' => true,
                'sort_order' => 2,
                'published_at' => now(),
            ],
            [
                'title' => 'Community Spirit - United in Blue',
                'subtitle' => 'Fan Engagement',
                'description' => 'Be part of the New Radiant family. Support our team, join our community events, and celebrate the beautiful game with fellow fans. Together we are stronger.',
                'image' => 'im2.jpg',
                'button_text' => 'Visit Store',
                'button_link' => '/store',
                'type' => 'promotion',
                'is_active' => true,
                'sort_order' => 3,
                'published_at' => now(),
            ],
            [
                'title' => 'New Radiant Returns to First Division',
                'subtitle' => 'Historic Comeback After Half a Decade',
                'description' => 'After five years of hard work and determination, New Radiant Sports Club has secured promotion back to the Dhivehi Premier League. This marks a new chapter in our storied history.',
                'image' => 'image.jpg',
                'button_text' => 'Read More',
                'button_link' => '/news',
                'type' => 'announcement',
                'is_active' => true,
                'sort_order' => 4,
                'published_at' => now(),
            ],
            [
                'title' => 'Academy Registration Now Open',
                'subtitle' => 'Develop Your Skills with the Best',
                'description' => 'Our youth academy is now accepting registrations for the 2024 season. Join our comprehensive training program designed to develop the next generation of Maldivian football stars.',
                'image' => 'img.jpg',
                'button_text' => 'Register Now',
                'button_link' => '/academy/enroll',
                'type' => 'promotion',
                'is_active' => true,
                'sort_order' => 5,
                'published_at' => now(),
            ],
            [
                'title' => 'Upcoming Match: New Radiant vs Victory',
                'subtitle' => 'Rasmee Dhandu Stadium',
                'description' => 'Don\'t miss our next home match against Victory SC. Come support the team as we continue our journey in the Dhivehi Premier League. Your support makes the difference.',
                'image' => 'team.jpg',
                'button_text' => 'Get Tickets',
                'button_link' => '/fixtures',
                'type' => 'announcement',
                'is_active' => true,
                'sort_order' => 6,
                'published_at' => now(),
                'expires_at' => now()->addDays(7),
            ],
            [
                'title' => 'Exclusive Merchandise Collection',
                'subtitle' => 'Show Your Support',
                'description' => 'Get the latest New Radiant SC merchandise including jerseys, accessories, and fan gear. Support your team in style with our premium collection.',
                'image' => 'jersey.jpg',
                'button_text' => 'Shop Now',
                'button_link' => '/store',
                'type' => 'promotion',
                'is_active' => true,
                'sort_order' => 7,
                'published_at' => now(),
            ],
            [
                'title' => 'Training Excellence - Professional Development',
                'subtitle' => 'World-Class Facilities',
                'description' => 'Train at our state-of-the-art facilities with experienced coaches. Our training programs are designed to develop technical skills, physical fitness, and tactical understanding.',
                'image' => 'champ.jpg',
                'button_text' => 'Learn More',
                'button_link' => '/academy',
                'type' => 'hero',
                'is_active' => true,
                'sort_order' => 8,
                'published_at' => now(),
            ]
        ];

        foreach ($heroSections as $section) {
            HeroSection::create($section);
        }
    }
}
