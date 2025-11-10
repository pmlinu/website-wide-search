<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'content' => 'We are a team of passionate developers building modern web applications using the latest technologies. Our expertise includes Laravel, PHP, Docker, and cloud infrastructure. We believe in clean code, best practices, and continuous learning.',
            ],
            [
                'title' => 'Privacy Policy',
                'content' => 'Your privacy is important to us. This privacy policy explains how we collect, use, and protect your personal information. We do not sell or share your data with third parties. All data is encrypted and stored securely. You have the right to access, modify, or delete your data at any time.',
            ],
            [
                'title' => 'Terms of Service',
                'content' => 'By using our service, you agree to these terms of service. Users must be at least 18 years old. You are responsible for maintaining the security of your account. We reserve the right to suspend accounts that violate our terms. All content posted must comply with applicable laws.',
            ],
            [
                'title' => 'Contact Us',
                'content' => 'Get in touch with our team. Email: contact@example.com. Phone: +1 (555) 123-4567. Office hours: Monday to Friday, 9 AM to 5 PM EST. We aim to respond to all inquiries within 24 hours.',
            ],
            [
                'title' => 'Our Services',
                'content' => 'We offer a wide range of web development services including custom Laravel application development, API development, database design, DevOps and deployment, code review and optimization, and technical consulting. Our team has years of experience building scalable applications.',
            ],
            [
                'title' => 'Careers',
                'content' => 'Join our growing team of developers. We are always looking for talented PHP developers, Laravel experts, DevOps engineers, and full-stack developers. We offer competitive salaries, remote work options, professional development opportunities, and a collaborative work environment.',
            ],
            [
                'title' => 'Documentation',
                'content' => 'Welcome to our comprehensive documentation. Here you will find guides, tutorials, API references, and code examples. Topics covered include getting started, authentication, search functionality, API endpoints, deployment guides, and troubleshooting common issues.',
            ],
            [
                'title' => 'Blog',
                'content' => 'Welcome to our developer blog. We regularly publish articles about Laravel development, PHP best practices, DevOps tips, database optimization, and industry trends. Subscribe to our newsletter to stay updated with the latest posts.',
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}

