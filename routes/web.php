<?php

use App\Http\Livewire\Posts\EditPost;
use App\Http\Livewire\Posts\ShowPost;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\Links\ManageLinks;
use App\Http\Controllers\WpApiController;
use App\Http\Controllers\WelcomeController;
use App\Http\Livewire\Posts\ShowVaultPosts;
use App\Http\Livewire\Pages\DashStandardPage;
use App\Http\Livewire\Posts\ShowChannelPosts;
use App\Http\Livewire\Posts\ShowCategoryPosts;
use App\Http\Controllers\UnsubscribeController;
use App\Http\Livewire\Subscriber\VerifySubscriber;
use App\Http\Controllers\ManageSubscriberController;

/*
* Guest Routes
*/
Route::get('/', WelcomeController::class)->name('welcome');
Route::get('home', HomeController::class)->name('home');

Route::resource('subscribers', ManageSubscriberController::class);
Route::Any('/subscribers/{id}/unsubscribe', UnsubscribeController::class)
            ->middleware('signed')->name('unsubscribe');

Route::post('verifyOTP/{id}/{otp}', VerifySubscriber::class);
Route::get('posts/{slug}', ShowPost::class)->name('showpost');
Route::get('category/posts/{cat_slug}', ShowCategoryPosts::class)->name('categoryposts');
Route::get('channel/posts/{chan_slug}', ShowChannelPosts::class)->name('channelposts');
Route::get('vault/', ShowVaultPosts::class)->name('posts.vault');

/*
* App Routes
*/
Route::middleware('auth')->group(function () {
    Route::get('dashboard', DashStandardPage::class)->name('dashboard');
    Route::get('posts/edit/{slug}/{origin}', EditPost::class)->name('edit.post');
    Route::get('links', ManageLinks::class)->name('links');
});

// ---------

require __DIR__.'/auth.php';

//Route::get('importImages', WpApiController::class);
