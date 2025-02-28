<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('channels')->insert([
            'name' => 'No Channel',
            'slug' => 'no-channel',
            'status' => '1',
            'sort' => 0,
            'created_at' => now(),
        ]);

        DB::table('channels')->insert([
            'name' => 'Television Productions',
            'slug' => 'television-productions',
            'status' => '1',
            'sort' => 1,
            'created_at' => now(),
        ]);

        DB::table('channels')->insert([
            'name' => 'Audio and Podcasts',
            'slug' => 'audio-and-podcasts',
            'status' => '1',
            'sort' => 2,
            'created_at' => now(),
        ]);

        DB::table('channels')->insert([
            'name' => 'Articles',
            'slug' => 'articles',
            'status' => '1',
            'sort' => 3,
            'created_at' => now(),
        ]);

        DB::table('channels')->insert([
            'name' => 'Published Books',
            'slug' => 'published-books',
            'status' => '1',
            'sort' => 4,
            'created_at' => now(),
        ]);
    }
}
