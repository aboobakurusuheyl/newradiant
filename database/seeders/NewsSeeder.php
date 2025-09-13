<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        
        $newsItems = [
            [
                'title' => 'New Radiant SC Returns to First Division',
                'content' => 'We are thrilled to announce that New Radiant Sports Club has successfully secured promotion back to the First Division of Maldivian football. This marks a historic moment for our club as we return to the top tier after a challenging period. The team has shown incredible determination and skill throughout the season, and we are proud of every player, coach, and staff member who contributed to this achievement.',
                'type' => 'general',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Academy Registration Now Open for 2024 Season',
                'content' => 'Registration for the New Radiant Academy 2024 season is now open! We welcome young footballers aged 8-18 to join our comprehensive training program. Our experienced coaching staff, led by Head Coach Sobah Mohamed, will provide professional training in a supportive environment. Early bird discounts available until the end of the month.',
                'type' => 'academy',
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'U16 Team Secures Championship Victory',
                'content' => 'Congratulations to our U16 team for their outstanding performance in the Youth Championship! The team displayed exceptional skill and teamwork throughout the tournament, culminating in a thrilling 3-2 victory in the final. Special recognition goes to our captain and all players for their dedication and hard work.',
                'type' => 'match',
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Training Schedule Update - Holiday Period',
                'content' => 'Please note that training schedules will be adjusted during the upcoming holiday period. Regular training sessions will resume on January 15th, 2024. All parents and students will receive updated schedules via email. For any questions, please contact the academy office.',
                'type' => 'announcement',
                'is_published' => true,
                'published_at' => now()->subHours(12),
            ],
            [
                'title' => 'New Radiant SC Celebrates 45 Years of Excellence',
                'content' => 'Founded in 1979, New Radiant Sports Club has been a cornerstone of Maldivian football for 45 years. Throughout our history, we have produced numerous national team players and won countless trophies. As we celebrate this milestone, we look forward to continuing our tradition of excellence and developing the next generation of football stars.',
                'type' => 'general',
                'is_published' => true,
                'published_at' => now()->subWeeks(2),
            ],
        ];

        foreach ($newsItems as $item) {
            News::create([
                'title' => $item['title'],
                'content' => $item['content'],
                'slug' => Str::slug($item['title']),
                'type' => $item['type'],
                'is_published' => $item['is_published'],
                'published_at' => $item['published_at'],
                'author_id' => $admin->id,
            ]);
        }
    }
}
