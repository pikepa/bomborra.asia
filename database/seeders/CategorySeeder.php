<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Welcome',
            'slug' => 'welcome',
            'type' => 'pages',
            'status' => '1',
            'created_at' => now(),

        ]);

        DB::table('categories')->insert([
            'name' => 'AsiaWatch',
            'slug' => 'asia-watch',
            'type' => 'main',
            'status' => '1',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'name' => 'The Vault',
            'slug' => 'the-vault',
            'type' => 'main',
            'status' => '1',
            'created_at' => now(),
        ]);
        DB::table('categories')->insert([
            'name' => 'Foreign Correspondence',
            'slug' => 'foreign-correspondence',
            'type' => 'main',
            'status' => '1',
            'created_at' => now(),

        ]);
        DB::table('categories')->insert([
            'name' => 'Highlights',
            'slug' => 'highlights',
            'type' => 'main',
            'status' => '1',
            'created_at' => now(),

        ]);
        DB::table('categories')->insert([
            'name' => 'Gallery',
            'slug' => 'gallery',
            'type' => 'main',
            'status' => '1',
            'created_at' => now(),

        ]);
    }
}
