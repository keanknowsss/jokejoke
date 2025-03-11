<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostForm extends Component
{
    use WithFileUploads;

    #[Rule((['required', 'string']))]
    public string $post_content;

    #[Rule(['nullable', 'sometimes', 'image', 'max: 5120', 'mimes:jpg,png'])]
    public $images;

    public function updatedImages() {
        try {
            $this->validateOnly('images');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('postSaved', [
                'status' => 'error',
                'type' => 'validation',
                'message' => $e->validator->errors()->toArray()
            ]);
        }
    }

    public function savePost() {

        try {
            $this->validate();

            if ($this->images) {
                $image_path = $this->images->store('uploads/posts', 'public');
            }

            DB::beginTransaction();

            Post::create([
                'user_id' => auth()->user()->id,
                'content' => $this->post_content,
                'attachments' => [$image_path]
            ]);

            DB::commit();

            $this->dispatch('postSaved', [
                'status' => 'success',
                'message' => 'Post successfully saved!'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // validation error
            $this->dispatch('postSaved', [
                'status' => 'error',
                'type' => 'validation',
                'message' => $e->validator->errors()->toArray()
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
dd($th);
            $this->dispatch('postSaved', [
                'status' => 'error',
                'type' => 'error',
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
