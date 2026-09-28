<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin Aerobag',
            'email' => 'admin@aerobag.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);
        
        \App\Models\Product::create([
            'name' => 'Premium Backpack',
            'description' => 'Durable backpack with a 15-inch laptop compartment. Perfect for travelers and university students.',
            'price' => 129.00,
            'stock' => 50,
            'image_path' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        ]);
        
        \App\Models\Product::create([
            'name' => 'Elegant Handbag',
            'description' => 'High-quality synthetic leather handbag with a modern design and spacious interior.',
            'price' => 89.00,
            'stock' => 20,
            'image_path' => 'https://images.unsplash.com/photo-1584916201218-f4242ceb4809?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        ]);
    }
}
