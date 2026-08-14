<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create or update Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Alexander Vance',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'active',
                'phone' => '+1 (555) 019-2834',
                'bio' => 'Lead System Administrator & Educational Curriculum Director.',
                'avatar_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&auto=format&fit=crop&q=80',
                'last_login_at' => now(),
            ]
        );

        // 2. Create Teacher Users
        $alexa = User::updateOrCreate(
            ['email' => 'alexa@example.com'],
            [
                'name' => 'Alexa Rivera',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
                'status' => 'active',
                'phone' => '+1 (555) 342-8891',
                'bio' => 'Senior Frontend Architect specializing in Vue 3, TypeScript, and high-performance UI engineering.',
                'avatar_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&auto=format&fit=crop&q=80',
                'last_login_at' => now()->subHours(2),
            ]
        );

        $jemini = User::updateOrCreate(
            ['email' => 'jemini@example.com'],
            [
                'name' => 'Jemini Patel',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
                'status' => 'active',
                'phone' => '+1 (555) 718-4420',
                'bio' => 'Full-Stack Developer & Database Specialist focusing on Laravel 12, MySQL optimization, and API security.',
                'avatar_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&auto=format&fit=crop&q=80',
                'last_login_at' => now()->subHours(5),
            ]
        );

        $anna = User::updateOrCreate(
            ['email' => 'anna@example.com'],
            [
                'name' => 'Anna Kowalska',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
                'status' => 'active',
                'phone' => '+1 (555) 890-1123',
                'bio' => 'UI/UX motion designer & design system specialist. Teaching modern CSS Grid, micro-interactions, and accessibility.',
                'avatar_url' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=300&auto=format&fit=crop&q=80',
                'last_login_at' => now()->subDay(),
            ]
        );

        // 3. Create Additional Team Members / Users for realistic data table experience
        $marcus = User::updateOrCreate(
            ['email' => 'marcus@example.com'],
            [
                'name' => 'Marcus Thorne',
                'password' => Hash::make('password123'),
                'role' => 'editor',
                'status' => 'active',
                'phone' => '+1 (555) 203-9944',
                'bio' => 'Content Reviewer and Video Post-Production Quality Assurance.',
                'avatar_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&auto=format&fit=crop&q=80',
                'last_login_at' => now()->subDays(3),
            ]
        );

        $elena = User::updateOrCreate(
            ['email' => 'elena@example.com'],
            [
                'name' => 'Elena Rostova',
                'password' => Hash::make('password123'),
                'role' => 'creator',
                'status' => 'active',
                'phone' => '+1 (555) 604-1289',
                'bio' => 'Guest instructor creating workshops on Cloud Infrastructure, Docker, and CI/CD pipelines.',
                'avatar_url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=300&auto=format&fit=crop&q=80',
                'last_login_at' => now()->subDays(4),
            ]
        );

        $david = User::updateOrCreate(
            ['email' => 'david@example.com'],
            [
                'name' => 'David Kim',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
                'status' => 'inactive',
                'phone' => '+1 (555) 912-3044',
                'bio' => 'Machine Learning Engineer & Python Data Analysis instructor.',
                'avatar_url' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=300&auto=format&fit=crop&q=80',
                'last_login_at' => now()->subDays(12),
            ]
        );

        // 4. Seed sample videos with user_id foreign key linkage
        $sampleVideos = [
            [
                'user_id' => $alexa->id,
                'teacher_name' => 'Alexa Rivera',
                'title' => 'Mastering Vue 3 & Composition API',
                'description' => 'Comprehensive deep-dive into reactive state management and modern frontend patterns with Vue 3.',
                'video_url' => 'https://player.vimeo.com/video/76979871',
                'thumbnail_path' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600&auto=format&fit=crop&q=80',
                'created_at' => now()->subDays(10),
            ],
            [
                'user_id' => $jemini->id,
                'teacher_name' => 'Jemini Patel',
                'title' => 'Full-Stack Laravel 12 Architecture',
                'description' => 'Learn how to construct robust, high-performance web applications using Laravel 12 and MySQL.',
                'video_url' => 'https://vimeo.com/76979871',
                'thumbnail_path' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=600&auto=format&fit=crop&q=80',
                'created_at' => now()->subDays(7),
            ],
            [
                'user_id' => $anna->id,
                'teacher_name' => 'Anna Kowalska',
                'title' => 'Advanced UI/UX Motion Design',
                'description' => 'Creating fluid micro-interactions, responsive layouts, and interactive components for modern web platforms.',
                'video_url' => 'https://player.vimeo.com/video/76979871',
                'thumbnail_path' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=600&auto=format&fit=crop&q=80',
                'created_at' => now()->subDays(5),
            ],
            [
                'user_id' => $alexa->id,
                'teacher_name' => 'Alexa Rivera',
                'title' => 'Database Performance Optimization & Indexing',
                'description' => 'Practical strategies for query profiling, indexing strategies, and relational database scaling.',
                'video_url' => 'https://player.vimeo.com/video/76979871',
                'thumbnail_path' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600&auto=format&fit=crop&q=80',
                'created_at' => now()->subDays(3),
            ],
            [
                'user_id' => $jemini->id,
                'teacher_name' => 'Jemini Patel',
                'title' => 'Building Secure Restful APIs with Token Auth',
                'description' => 'Best practices for API authentication, rate limiting, request validation, and error response formatting.',
                'video_url' => 'https://vimeo.com/76979871',
                'thumbnail_path' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600&auto=format&fit=crop&q=80',
                'created_at' => now()->subDays(2),
            ],
            [
                'user_id' => $anna->id,
                'teacher_name' => 'Anna Kowalska',
                'title' => 'CSS Grid & Modern Responsive Layouts',
                'description' => 'Step-by-step masterclass on building grid layouts without third-party heavy dependencies.',
                'video_url' => 'https://player.vimeo.com/video/76979871',
                'thumbnail_path' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=600&auto=format&fit=crop&q=80',
                'created_at' => now()->subDay(),
            ],
            [
                'user_id' => $elena->id,
                'teacher_name' => 'Elena Rostova',
                'title' => 'Docker & Kubernetes for Cloud Deployments',
                'description' => 'Containerizing enterprise Laravel and Node applications for production deployment in Kubernetes clusters.',
                'video_url' => 'https://player.vimeo.com/video/76979871',
                'thumbnail_path' => 'https://images.unsplash.com/photo-1607799279861-4dd421887fb3?w=600&auto=format&fit=crop&q=80',
                'created_at' => now()->subHours(12),
            ],
        ];

        // Clear existing videos to avoid duplication and link foreign keys cleanly
        Video::truncate();
        foreach ($sampleVideos as $videoData) {
            Video::create($videoData);
        }
    }
}
