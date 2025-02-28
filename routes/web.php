<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManageSubscriberController;
use App\Http\Controllers\UnsubscribeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\WpApiController;
use App\Livewire\CreatePost;
use App\Livewire\Emails\CreateUpdateEmail;
use App\Livewire\Links\ManageLinks;
use App\Livewire\Pages\DashStandardPage;
use App\Livewire\Posts\EditPost;
use App\Livewire\Posts\ShowCategoryPosts;
use App\Livewire\Posts\ShowChannelPosts;
use App\Livewire\Posts\ShowLatestPosts;
use App\Livewire\Posts\ShowPost;
use App\Livewire\Posts\ShowPostUpdates;
use App\Livewire\Posts\ShowVaultPosts;
use App\Livewire\Subscriber\ManageSubscribers;
use App\Livewire\Subscriber\VerifySubscriber;
use Illuminate\Support\Facades\Route;

/*
* Guest Routes
*/
Route::get('/', WelcomeController::class)->name('welcome');
Route::get('home', HomeController::class)->name('home');

Route::resource('/subscribers', ManageSubscriberController::class)->only(['create', 'store']);
Route::Any('/subscribers/{id}/unsubscribe', UnsubscribeController::class)->middleware('signed')->name('unsubscribe');

Route::get('latest', ShowLatestPosts::class)->name('posts.latest');
Route::Any('verifyOTP/{id}/{otp}', VerifySubscriber::class);
Route::get('posts/{slug}', ShowPost::class)->name('showpost');
Route::get('category/posts/{cat_slug}', ShowCategoryPosts::class)->name('categoryposts');
Route::get('channel/posts/{chan_slug}', ShowChannelPosts::class)->name('channelposts');
Route::get('vault', ShowVaultPosts::class)->name('posts.vault');

/*
* App Routes
*/
Route::middleware('auth')->group(function (): void {
    Route::get('dashboard/{page?}', DashStandardPage::class)->name('dashboard');
    Route::get('siteupdates', ShowPostUpdates::class)->name('site-updates');
    Route::get('manage/subscribers', ManageSubscribers::class)->name('manage.subscribers');
    Route::get('/post/create', CreatePost::class)->name('create.post');
    Route::get('posts/edit/{slug}/{origin}', EditPost::class)->name('edit.post');
    Route::get('manage/links', ManageLinks::class)->name('manage.links');
    Route::get('email/composeandsendupdate', CreateUpdateEmail::class)->name('email.compose');
});

// ---------

require __DIR__.'/auth.php';

// Route::get('importImages', WpApiController::class);
