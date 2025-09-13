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
        // Clear existing news data
        News::truncate();
        
        $admin = User::where('role', 'admin')->first();
        
        $newsItems = [
            [
                'title' => 'New Radiant SC Returns to First Division',
                'content' => 'We are thrilled to announce that New Radiant Sports Club has successfully secured promotion back to the First Division of Maldivian football. This marks a historic moment for our club as we return to the top tier after a challenging period. The team has shown incredible determination and skill throughout the season, and we are proud of every player, coach, and staff member who contributed to this achievement. The promotion comes after an outstanding season where we finished second in the Second Division, securing our place among the elite clubs of Maldivian football once again.',
                'excerpt' => 'Historic promotion back to the top tier of Maldivian football after years of hard work and determination.',
                'type' => 'general',
                'category' => 'general',
                'tags' => ['promotion', 'first-division', 'achievement'],
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(5),
                'featured_image' => 'img/team.jpg',
            ],
            [
                'title' => 'Academy Registration Now Open for 2024 Season',
                'content' => 'Registration for the New Radiant Academy 2024 season is now open! We welcome young footballers aged 8-18 to join our comprehensive training program. Our experienced coaching staff, led by Head Coach Sobah Mohamed, will provide professional training in a supportive environment. Early bird discounts available until the end of the month. The academy offers age-appropriate training programs, modern facilities, and a pathway to professional football. Don\'t miss this opportunity to be part of the New Radiant family!',
                'excerpt' => 'Join our comprehensive youth development program with experienced coaching staff and professional training.',
                'type' => 'announcement',
                'category' => 'academy',
                'tags' => ['academy', 'registration', 'youth-development'],
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(3),
                'featured_image' => 'img/image.jpg',
            ],
            [
                'title' => 'U16 Team Secures Championship Victory',
                'content' => 'Congratulations to our U16 team for their outstanding performance in the Youth Championship! The team displayed exceptional skill and teamwork throughout the tournament, culminating in a thrilling 3-2 victory in the final. Special recognition goes to our captain and all players for their dedication and hard work. This victory marks our third youth championship in the last five years, demonstrating our commitment to developing young talent.',
                'excerpt' => 'Outstanding performance leads to thrilling 3-2 victory in the Youth Championship final.',
                'type' => 'general',
                'category' => 'matches',
                'tags' => ['u16', 'championship', 'victory'],
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(1),
                'featured_image' => 'img/champ.jpg',
            ],
            [
                'title' => 'New Signing: International Striker Joins First Team',
                'content' => 'New Radiant SC is delighted to announce the signing of international striker Ahmed Ali from the Maldives national team. The 24-year-old forward brings extensive experience and a proven goal-scoring record. Ali has represented the Maldives in international competitions and will strengthen our attacking options for the upcoming First Division campaign. Welcome to the New Radiant family, Ahmed!',
                'excerpt' => 'International striker Ahmed Ali joins the club to strengthen our attacking options for the new season.',
                'type' => 'general',
                'category' => 'transfers',
                'tags' => ['signing', 'striker', 'international'],
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(2),
                'featured_image' => 'img/im2.jpg',
            ],
            [
                'title' => 'Training Schedule Update - Holiday Period',
                'content' => 'Please note that training schedules will be adjusted during the upcoming holiday period. Regular training sessions will resume on January 15th, 2024. All parents and students will receive updated schedules via email. For any questions, please contact the academy office. We wish all our players and their families a wonderful holiday season!',
                'excerpt' => 'Training schedules adjusted for holiday period with regular sessions resuming January 15th.',
                'type' => 'announcement',
                'category' => 'announcements',
                'tags' => ['training', 'schedule', 'holiday'],
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subHours(12),
                'featured_image' => null,
            ],
            [
                'title' => 'New Radiant SC Celebrates 45 Years of Excellence',
                'content' => 'Founded in 1979, New Radiant Sports Club has been a cornerstone of Maldivian football for 45 years. Throughout our history, we have produced numerous national team players and won countless trophies. As we celebrate this milestone, we look forward to continuing our tradition of excellence and developing the next generation of football stars. Our legacy includes multiple league titles, cup victories, and the development of players who have gone on to represent the Maldives internationally.',
                'excerpt' => 'Celebrating 45 years of football excellence and tradition in Maldivian football.',
                'type' => 'general',
                'category' => 'general',
                'tags' => ['anniversary', 'history', 'excellence'],
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subWeeks(2),
                'featured_image' => 'img/img.jpg',
            ],
            [
                'title' => 'First Team Pre-Season Training Begins',
                'content' => 'The New Radiant SC first team has officially begun their pre-season training program in preparation for the upcoming First Division campaign. The squad, led by Head Coach Sobah Mohamed, will undergo intensive training sessions focusing on fitness, tactics, and team cohesion. The pre-season program includes friendly matches against local and regional teams to test our preparations.',
                'excerpt' => 'Intensive pre-season training program begins as we prepare for the First Division campaign.',
                'type' => 'general',
                'category' => 'training',
                'tags' => ['pre-season', 'training', 'first-team'],
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(4),
                'featured_image' => 'img/immm.jpg',
            ],
            [
                'title' => 'Academy Graduates Join First Team',
                'content' => 'We are proud to announce that three academy graduates have been promoted to the first team squad for the upcoming season. These young players have shown exceptional development and dedication throughout their academy journey. This promotion reflects our commitment to developing local talent and providing pathways from youth football to professional level.',
                'excerpt' => 'Three academy graduates promoted to first team, showcasing our commitment to youth development.',
                'type' => 'general',
                'category' => 'academy',
                'tags' => ['academy', 'graduates', 'promotion'],
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(6),
                'featured_image' => 'img/542133544_122145862232860207_3368542918030329377_n.jpg',
            ],
            [
                'title' => 'Stadium Renovation Project Completed',
                'content' => 'The Rasmee Dhandu Stadium renovation project has been successfully completed, providing our players and fans with world-class facilities. The upgrades include improved seating, modern changing rooms, enhanced lighting, and better accessibility features. These improvements will enhance the matchday experience for everyone involved with New Radiant SC.',
                'excerpt' => 'Stadium renovation completed with world-class facilities and enhanced matchday experience.',
                'type' => 'general',
                'category' => 'facilities',
                'tags' => ['stadium', 'renovation', 'facilities'],
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subWeeks(1),
                'featured_image' => 'img/542753023_122145862172860207_608110234686854085_n.jpg',
            ],
            [
                'title' => 'Community Outreach Program Launched',
                'content' => 'New Radiant SC has launched a new community outreach program aimed at promoting football development across the Maldives. The program includes free coaching clinics, equipment donations to local schools, and educational workshops on sports nutrition and fitness. We believe in giving back to the community that has supported us throughout our 45-year history.',
                'excerpt' => 'New community outreach program promotes football development and gives back to local communities.',
                'type' => 'general',
                'category' => 'community',
                'tags' => ['community', 'outreach', 'development'],
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(8),
                'featured_image' => null,
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
