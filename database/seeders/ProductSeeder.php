<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop Computer',
                'description' => 'High-performance laptop with Intel Core i7 processor, 16GB RAM, and 512GB SSD. Perfect for developers and content creators who need reliable computing power on the go.',
                'category' => 'Electronics',
                'price' => 1299.99,
            ],
            [
                'name' => 'Wireless Bluetooth Headphones',
                'description' => 'Premium noise-cancelling wireless headphones with 30-hour battery life. Crystal clear audio quality and comfortable design for all-day wear.',
                'category' => 'Audio',
                'price' => 249.99,
            ],
            [
                'name' => 'Programming Books Bundle',
                'description' => 'Complete collection of essential programming books covering PHP, Laravel, JavaScript, Python, and software architecture. Perfect for developers looking to expand their knowledge.',
                'category' => 'Books',
                'price' => 199.99,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'Professional mechanical keyboard with RGB backlighting and Cherry MX switches. Ideal for programmers who type for extended periods.',
                'category' => 'Computer Accessories',
                'price' => 149.99,
            ],
            [
                'name' => 'Ergonomic Office Chair',
                'description' => 'Premium ergonomic office chair with lumbar support, adjustable armrests, and breathable mesh back. Designed for comfortable long coding sessions.',
                'category' => 'Furniture',
                'price' => 399.99,
            ],
            [
                'name' => 'External SSD Drive 1TB',
                'description' => 'Ultra-fast portable SSD with USB 3.2 Gen 2 support. Transfer speeds up to 1050MB/s. Perfect for developers who need fast, reliable backup storage.',
                'category' => 'Storage',
                'price' => 129.99,
            ],
            [
                'name' => 'Web Development Course',
                'description' => 'Comprehensive online course covering HTML, CSS, JavaScript, PHP, Laravel, and modern web development practices. Includes lifetime access and certificate.',
                'category' => 'Education',
                'price' => 89.99,
            ],
            [
                'name' => '4K Monitor 27-inch',
                'description' => 'Professional 4K UHD monitor with IPS panel, 99% sRGB color accuracy, and USB-C connectivity. Perfect for developers and designers.',
                'category' => 'Displays',
                'price' => 449.99,
            ],
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with precision tracking and long battery life. Comfortable grip for extended use.',
                'category' => 'Computer Accessories',
                'price' => 39.99,
            ],
            [
                'name' => 'Laptop Stand',
                'description' => 'Adjustable aluminum laptop stand with cooling design. Improves posture and airflow for your laptop during development work.',
                'category' => 'Computer Accessories',
                'price' => 49.99,
            ],
            [
                'name' => 'USB-C Hub',
                'description' => '7-in-1 USB-C hub with HDMI, USB 3.0, SD card reader, and power delivery. Essential accessory for modern laptops.',
                'category' => 'Computer Accessories',
                'price' => 59.99,
            ],
            [
                'name' => 'Code Editor Theme Pack',
                'description' => 'Collection of premium dark and light themes for VS Code, PHPStorm, and other popular code editors. Easy on the eyes for long coding sessions.',
                'category' => 'Software',
                'price' => 19.99,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

