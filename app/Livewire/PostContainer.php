<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class PostContainer extends Component
{
    public string $type;

    public Collection $posts;

    #[On('postSaved')]
    public function refreshPosts() {
        $this->posts = $this->type === 'all' ?
            Post::with('user')->latest()->get() :
            auth()->user()->posts()->with('user')->latest()->get();
    }

    public function mount(string $type = 'all') {
        $this->type = $type;

        $this->refreshPosts();
    }

    public function render()
    {
        return view('livewire.post-container', [
            'posts' => $this->posts
        ]);
    }
}
