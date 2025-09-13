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
                'excerpt' => 'Historic promotion back to the top tier of Maldivian football after years of hard work and determination.',
                'type' => 'general',
                'category' => 'general',
                'tags' => ['promotion', 'first-division', 'achievement'],
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(5),
                'featured_image' => 'https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d?w=800&h=400&fit=crop',
            ],
            [
                'title' => 'Academy Registration Now Open for 2024 Season',
                'content' => 'Registration for the New Radiant Academy 2024 season is now open! We welcome young footballers aged 8-18 to join our comprehensive training program. Our experienced coaching staff, led by Head Coach Sobah Mohamed, will provide professional training in a supportive environment. Early bird discounts available until the end of the month.',
                'excerpt' => 'Join our comprehensive youth development program with experienced coaching staff and professional training.',
                'type' => 'announcement',
                'category' => 'academy',
                'tags' => ['academy', 'registration', 'youth-development'],
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(3),
                'featured_image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=400&fit=crop',
            ],
            [
                'title' => 'U16 Team Secures Championship Victory',
                'content' => 'Congratulations to our U16 team for their outstanding performance in the Youth Championship! The team displayed exceptional skill and teamwork throughout the tournament, culminating in a thrilling 3-2 victory in the final. Special recognition goes to our captain and all players for their dedication and hard work.',
                'excerpt' => 'Outstanding performance leads to thrilling 3-2 victory in the Youth Championship final.',
                'type' => 'general',
                'category' => 'matches',
                'tags' => ['u16', 'championship', 'victory'],
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(1),
                'featured_image' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800&h=400&fit=crop',
            ],
            [
                'title' => 'Training Schedule Update - Holiday Period',
                'content' => 'Please note that training schedules will be adjusted during the upcoming holiday period. Regular training sessions will resume on January 15th, 2024. All parents and students will receive updated schedules via email. For any questions, please contact the academy office.',
                'excerpt' => 'Training schedules adjusted for holiday period with regular sessions resuming January 15th.',
                'type' => 'announcement',
                'category' => 'announcements',
                'tags' => ['training', 'schedule', 'holiday'],
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subHours(12),
            ],
            [
                'title' => 'New Radiant SC Celebrates 45 Years of Excellence',
                'content' => 'Founded in 1979, New Radiant Sports Club has been a cornerstone of Maldivian football for 45 years. Throughout our history, we have produced numerous national team players and won countless trophies. As we celebrate this milestone, we look forward to continuing our tradition of excellence and developing the next generation of football stars.',
                'excerpt' => 'Celebrating 45 years of football excellence and tradition in Maldivian football.',
                'type' => 'general',
                'category' => 'general',
                'tags' => ['anniversary', 'history', 'excellence'],
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subWeeks(2),
                'featured_image' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800&h=400&fit=crop',
            ],
        ];

        foreach ($newsItems as $item) {
            News::create([
                'title' => $item['title'],
                'content' => $item['content'],
                'excerpt' => $item['excerpt'],
                'slug' => Str::slug($item['title']),
                'type' => $item['type'],
                'category' => $item['category'],
                'tags' => $item['tags'],
                'is_published' => $item['is_published'],
                'is_featured' => $item['is_featured'],
                'published_at' => $item['published_at'],
                'featured_image' => $item['featured_image'] ?? null,
                'author_id' => $admin->id,
            ]);
        }
    }
}
