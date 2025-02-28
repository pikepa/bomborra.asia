<?php

declare(strict_types=1);

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

final class ShowVaultPosts extends Component
{
    use WithPagination;

    public function render()
    {
        return view(
            'livewire.posts.show-vault-posts',
            ['posts' => Post::where('is_in_vault', true)
                ->orderBy('published_at', 'desc')->paginate(12), ]
        );
    }
}
