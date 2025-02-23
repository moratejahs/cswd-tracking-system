<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Power Tools',
            'Hand Tools',
            'Fasteners',
            'Building Materials',
            'Paint',
            'Plumbing',
            'Electrical',
            'Storage & Organization',
            'Automotive',
            'Safety'
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create([
                'category_name' => $category
            ]);
        }
    }
}
