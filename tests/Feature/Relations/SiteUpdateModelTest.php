<?php

use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\SiteUpdate;
use App\Models\User;

uses()->group('models');

beforeEach(function () {
    User::factory()->create();
    Category::factory()->create();
    Channel::factory()->create();
});

test('a belongs to a post', function () {
    //  $this->withoutExceptionHandling();
    $siteupdate = Siteupdate::factory()
        ->has(Post::factory())
        ->create();
    expect($siteupdate->post)
        ->toBeInstanceOf(Post::class);
});
test('a user owns a siteupdate', function () {
    $user = User::factory()->create();
    $siteupdate = Siteupdate::factory()
        ->create(['user_id' => $user->id]);

    expect($siteupdate->owner)
        ->toBeInstanceOf(User::class);
    expect($siteupdate->owner->name)
        ->toBe($user->name);
});
test('A site update can be filtered via its associate Post title a Filter ', function () {
    $post1 = Post::factory()->create(['title' => 'peter']);
    $post2 = Post::factory()->create(['title' => 'paul']);

    $siteupdate1 = SiteUpdate::factory()->create(['post_id' => $post1->id]);
    $siteupdate2 = SiteUpdate::factory()->create(['post_id' => $post2->id]);

    $found = SiteUpdate::filtertitle('pet')->with('post')->get();
    expect($found->count())->toBe(1);

    $found = SiteUpdate::filtertitle('pet')->with('post')->first();
    expect($found->post->title)->toBe('peter');
});
