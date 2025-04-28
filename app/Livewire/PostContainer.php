<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class PostContainer extends Component
{
    public ?string $user_id;

    public Collection $posts;

    #[On('postSaved')]
    #[On('postDeleted')]
    #[On('postUpdated')]
    public function refreshPosts() {
        $this->posts = $this->user_id ?
            auth()->user()->posts()->with('user')->latest()->get() :
            Post::with('user')->latest()->get();
    }

    public function mount($user_id = null) {
        $this->user_id = $user_id;

        $this->refreshPosts();
    }

    public function render()
    {
        return view('livewire.post-container', [
            'posts' => $this->posts
        ]);
    }
}
