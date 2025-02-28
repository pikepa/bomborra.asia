<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;

final class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate sitemap';

    public function handle()
    {
        // Manually create sitemap
        $sitemap = Sitemap::create();

        // Static pages
        $sitemap->add('/');

        // Dynamic pages
        $posts = Post::all();
        foreach ($posts as $post) {
            $sitemap->add("/posts/{$post->slug}");
        }

        $sitemap->writeToFile(public_path('sitemap_posts.xml'));
    }
}
