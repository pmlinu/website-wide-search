<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What is Laravel?',
                'answer' => 'Laravel is a free, open-source PHP web application framework with expressive, elegant syntax. It follows the MVC architectural pattern and includes features like routing, authentication, sessions, caching, and more.',
            ],
            [
                'question' => 'How do I install Laravel?',
                'answer' => 'You can install Laravel using Composer by running "composer create-project laravel/laravel project-name" or by using Laravel installer "laravel new project-name". Make sure you have PHP 8.1+ and Composer installed.',
            ],
            [
                'question' => 'What is Laravel Scout?',
                'answer' => 'Laravel Scout is a simple, driver-based solution for adding full-text search to your Eloquent models. It automatically keeps your search indexes in sync with your database records and supports multiple search engines.',
            ],
            [
                'question' => 'How does the search functionality work?',
                'answer' => 'Our search system uses Laravel Scout to index content from blog posts, products, pages, and FAQs. When you search, it queries all indexes simultaneously and returns combined results ranked by relevance.',
            ],
            [
                'question' => 'Can I search by partial words?',
                'answer' => 'Yes, our search supports partial matching. For example, searching for "deve" will match "developer", "development", and "device". This makes it easier to find content even with incomplete search terms.',
            ],
            [
                'question' => 'What is Docker?',
                'answer' => 'Docker is a platform that enables developers to package applications into containers. Containers are standardized executable components combining application source code with all the dependencies needed to run that code in any environment.',
            ],
            [
                'question' => 'How do I run the application with Docker?',
                'answer' => 'Clone the repository, navigate to the project directory, and run "docker-compose up -d". This will start all required services including the application, database, and Redis. See the README for detailed instructions.',
            ],
            [
                'question' => 'What database does this application use?',
                'answer' => 'By default, this application uses PostgreSQL, but it can be configured to use MySQL or other databases supported by Laravel. The database configuration is in the .env file.',
            ],
            [
                'question' => 'How are search queries logged?',
                'answer' => 'Every search query is automatically logged with the search term, number of results, user ID (if authenticated), IP address, and timestamp. This data helps analyze search patterns and improve the search experience.',
            ],
            [
                'question' => 'Can I rebuild the search index?',
                'answer' => 'Yes, administrators can rebuild the search index by calling the /api/search/rebuild-index endpoint. This is useful after importing large amounts of data or if the index becomes out of sync.',
            ],
            [
                'question' => 'What are Laravel Queues?',
                'answer' => 'Laravel Queues provide a unified API for deferring time-consuming tasks like sending emails or processing files. This application uses queues for search index synchronization to improve performance.',
            ],
            [
                'question' => 'How do I access admin endpoints?',
                'answer' => 'Admin endpoints require authentication and admin privileges. First, obtain an API token by authenticating with admin credentials, then include the token in the Authorization header as "Bearer {token}".',
            ],
            [
                'question' => 'What is API rate limiting?',
                'answer' => 'API rate limiting prevents abuse by restricting the number of requests a client can make in a given time period. Laravel provides built-in rate limiting middleware that can be configured per route.',
            ],
            [
                'question' => 'How can I contribute to this project?',
                'answer' => 'Contributions are welcome! Fork the repository, create a feature branch, make your changes, write tests, and submit a pull request. Please follow the coding standards and include documentation for new features.',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}

