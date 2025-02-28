<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'cover_image' => 'https://d18sfhl837dknt.cloudfront.net/featured/J1aR7bQQON3gwr3GipXyXJ1gmA3FSwKiRfjCj8hr.jpg',
            'title' => 'Bomborra Media Productions',
            'body' => '<div>Bomborra is a loose knitted production house and publisher. Registered in Hong Kong, Bomborra also acts as a resource for journalistic works, ranging from the written word and photo to audio and video with a focus on East Asia.<br><br></div><div><em>Far East Correspondent</em> is a portal that delivers readers to selected articles focusing on news analysis from contributing correspondents in Southeast Asia.<br><br></div><div><em>ASIAWATCH</em> is an online magazine for those who watch the region. Contributors include think tanks with an angle to grind, young journalists looking for a launch vehicle, expats with a worthy opinion and senior hands who’d appreciate another display cabinet.<br><br></div><div><em>Bomborra Images</em> is a selection of photo essays and an image library compiled from photographers, artists and correspondents working in Southeast Asia and further afield.<br><br></div><div>Bomborra Productions was founded by Australian journalist <a href="https://bomborra.asia/?page_id=98"><strong>Luke Hunt</strong></a>, Hong Kong-based <a href="https://www.youtube.com/watch?v=8ORPvEK-cfk"><strong>Diane Stormont</strong></a> and South African reporter and the photographer <a href="http://www.robertcarmichael.net/Robert_Carmichael/Welcome.html"><strong>Robert Carmichael</strong></a> in 2005. Luke Hunt is currently publisher.<br><br></div>',
            'slug' => 'bomborra-media-productions',
            'created_at' => now(),
            'published_at' => now(),
            'channel_id' => Channel::first()->id,
            'author_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::first()->id,
            'is_in_vault' => false,
            'meta_description' => 'To be Defined',
            'published_at' => now(),
        ]);

        Post::factory()->count(5)->create();
    }
}
