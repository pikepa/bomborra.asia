<?php

namespace App\Models;

use Carbon\Carbon;

class WpApi
{
    protected $url = 'http://bomborra.asia/wp-json/wp/v2/';

    public function importPosts($page = '1')
    {
        for ($page = 1; $page <= 9; $page++) {
            $posts = collect($this->getJson($this->url.'posts/?_embed&filter[orderby]=modified&per_page=100&page='.$page));
            foreach ($posts as $post) {
                $this->syncPost($post);
                echo nl2br($post->id.',');
            }
        }
    }

    public function featuredImage($data)
    {
        if (property_exists($data, 'wp:featuredmedia')) {
            $data = head($data->{'wp:featuredmedia'});
            if (isset($data->source_url)) {
                return $data->source_url;
            }
        }

        return null;
    }

    public function getCategory($data)
    {
        $category = collect($data)->collapse()->where('taxonomy', 'category')->first();
        $found = Category::where('wp_id', $category->id)->first();
        if ($found) {
            return $found->id;
        }
        $cat = new Category;
        //  $cat->id = $category->id;
        $cat->wp_id = $category->id;
        $cat->name = $category->name;
        $cat->slug = $category->slug;
        $cat->description = '';
        $cat->save();

        return $cat->id;
    }

    public function importImages()
    {
        $posts = Post::where('id', '>', 4000)->get();
        foreach ($posts as $post) {
            $post->addMediaFromUrl($post->temp_url)
                ->toMediaCollection('photos', 's3');

            $temp = Post::find($post->id)->getFirstMediaUrl('photos');
            $post->cover_image = $temp;
            $post->update();
        }
    }

    protected function getJson($url)
    {
        $response = file_get_contents($url, false);

        return json_decode($response);
    }

    protected function syncPost($data)
    {
        $found = Post::where('id', $data->id)->first();

        if (! $found) {
            return $this->createPost($data);
        }

        if ($found) {
            return $this->updatePost($found, $data);
        }
    }

    protected function carbonDate($date)
    {
        return Carbon::parse($date);
    }

    protected function createPost($data)
    {
        $post = new Post;
        $post->id = $data->id;
        $post->wp_id = $data->id;
        //  $post->user_id = $this->getAuthor($data->_embedded->author);
        $post->title = $data->title->rendered;
        $post->slug = $data->slug;
        if (! $this->featuredImage($data->_embedded)) {
            // $post->cover_image = 'https://d18sfhl837dknt.cloudfront.net/featured/J1aR7bQQON3gwr3GipXyXJ1gmA3FSwKiRfjCj8hr.jpg';
            $post->cover_image = 'https://noimage.com';
        } else {
            $post->cover_image = $this->featuredImage($data->_embedded);
        }
        // $post->featured = ($data->sticky) ? 1 : null;
        $post->meta_description = $data->excerpt->rendered;
        $post->body = $data->content->rendered;
        // $post->format = $data->format;
        //  $post->status = 'publish';
        $post->published_at = $this->carbonDate($data->date);
        $post->created_at = $this->carbonDate($data->date);
        $post->updated_at = $this->carbonDate($data->modified);
        $post->category_id = $this->getCategory($data->_embedded->{'wp:term'});
        $post->channel_id = 8;
        $post->author_id = 2;
        $post->save();
        // $this->syncTags($post, $data->_embedded->{"wp:term"});
        return $post;
    }

    protected function updatePost($found, $data)
    {
        $post = $found;
        if (! $this->featuredImage($data->_embedded)) {
            //   $post->cover_image = 'https://d18sfhl837dknt.cloudfront.net/featured/J1aR7bQQON3gwr3GipXyXJ1gmA3FSwKiRfjCj8hr.jpg';
            $post->cover_image = 'https://d18sfhl837dknt.cloudfront.net/Dev/image_missing.jpg';
        } else {
            $post->cover_image = $this->featuredImage($data->_embedded);
        }
        $post->update();

        return $post;
    }

    private function syncTags(Post $post, $tags)
    {
        $tags = collect($tags)->collapse()->where('taxonomy', 'post_tag')->pluck('name')->toArray();
        if (count($tags) > 0) {
            $post->setTags($tags);
        }
    }
}
