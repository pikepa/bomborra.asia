<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Peter Pike',
            'email' => 'pikepeter@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $this->call([
            CategorySeeder::class,
            ChannelSeeder::class,
            PostSeeder::class,
        ]);
    }
}
