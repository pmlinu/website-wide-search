<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Getting Started with Laravel',
                'body' => 'Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as authentication, routing, sessions, caching, and more.',
                'tags' => ['laravel', 'php', 'tutorial', 'web development'],
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Introduction to Docker Containers',
                'body' => 'Docker is a set of platform as a service products that use OS-level virtualization to deliver software in packages called containers. Containers are isolated from one another and bundle their own software, libraries and configuration files; they can communicate with each other through well-defined channels.',
                'tags' => ['docker', 'containers', 'devops', 'deployment'],
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Modern PHP Development Best Practices',
                'body' => 'PHP has evolved significantly over the years. Modern PHP development involves using composer for dependency management, following PSR standards, implementing design patterns, writing testable code, and leveraging modern frameworks like Laravel, Symfony, or others.',
                'tags' => ['php', 'best practices', 'development', 'coding standards'],
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Understanding RESTful APIs',
                'body' => 'REST (Representational State Transfer) is an architectural style for providing standards between computer systems on the web, making it easier for systems to communicate with each other. RESTful systems are characterized by how they are stateless and separate the concerns of client and server.',
                'tags' => ['api', 'rest', 'web services', 'architecture'],
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Database Design Fundamentals',
                'body' => 'Good database design is crucial for creating efficient, scalable applications. This includes understanding normalization, indexing strategies, choosing the right data types, defining relationships properly, and planning for future growth. PostgreSQL and MySQL are popular choices for web applications.',
                'tags' => ['database', 'sql', 'design', 'architecture'],
                'published_at' => now()->subDays(15),
            ],
            [
                'title' => 'Laravel Scout: Full-Text Search Made Easy',
                'body' => 'Laravel Scout provides a simple, driver-based solution for adding full-text search to your Eloquent models. Scout will automatically keep your search indexes in sync with your Eloquent records. Currently, Scout supports Algolia, MeiliSearch, and database drivers.',
                'tags' => ['laravel', 'scout', 'search', 'full-text search'],
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Advanced Git Workflows',
                'body' => 'Git is a distributed version control system that enables teams to collaborate effectively. Understanding advanced Git workflows like Git Flow, feature branches, pull requests, rebasing, and cherry-picking can greatly improve your development process and team collaboration.',
                'tags' => ['git', 'version control', 'workflow', 'collaboration'],
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'Testing in Laravel Applications',
                'body' => 'Testing is an essential part of building reliable applications. Laravel provides excellent support for testing with PHPUnit. You can write feature tests, unit tests, and browser tests using Laravel Dusk. Testing helps catch bugs early and ensures your code works as expected.',
                'tags' => ['laravel', 'testing', 'phpunit', 'quality assurance'],
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Redis and Laravel Queues',
                'body' => 'Laravel queues provide a unified API across a variety of different queue backends, such as Redis, database, Beanstalkd, Amazon SQS, and more. Queues allow you to defer the processing of time-consuming tasks, such as sending emails or processing uploaded files.',
                'tags' => ['laravel', 'redis', 'queues', 'performance'],
                'published_at' => now()->subDays(6),
            ],
            [
                'title' => 'Building Microservices with PHP',
                'body' => 'Microservices architecture is an approach to developing applications as a suite of small, independently deployable services. Each service runs in its own process and communicates with lightweight mechanisms. PHP, with frameworks like Laravel and Symfony, is well-suited for building microservices.',
                'tags' => ['microservices', 'php', 'architecture', 'distributed systems'],
                'published_at' => now()->subDays(20),
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create($post);
        }
    }
}

