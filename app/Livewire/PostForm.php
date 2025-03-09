<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PostForm extends Component
{
    #[Validate((['required', 'string']))]
    public string $content;

    public function savePost() {
        $this->validate();

        DB::beginTransaction();

        try {
            Post::create([
                'user_id' => auth()->user()->id,
                'content' => $this->content,
                'attachments' => null
            ]);

            DB::commit();

            $this->dispatch('postSaved', [
                'status' => 'success',
                'message' => 'Post successfully saved!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->dispatch('postSaved', [
                'status' => 'error',
                'message' => 'Something went wrong. Please try again.'
            ]);
        }


        $this->reset();
    }

    public function render()
    {
        return view('livewire.post-form');
    }
}
