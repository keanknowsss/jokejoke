<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class PostContainer extends Component
{
    public ?User $user;

    public Collection $posts;

    #[On('postSaved')]
    #[On('postDeleted')]
    #[On('postUpdated')]
    public function refreshPosts() {
        $this->posts = $this->user ?
            $this->user->posts()->with('user')->latest()->get() :
            Post::with('user')->latest()->get();
    }

    public function mount($user_id = null) {
        $this->user = User::find($user_id);

        $this->refreshPosts();
    }

    public function render()
    {
        return view('livewire.post-container', [
            'posts' => $this->posts
        ]);
    }
}
