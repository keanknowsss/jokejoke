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

    #[Rule(['nullable', 'array'])]
    public array $images = [];

    public function rules()
    {
        return [
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5124', 'mimes:jpg,png'], // Validate each image
        ];
    }

    public function messages()
    {
        return [
            'images.*.image' => 'Each image must be a valid image file.',
            'images.*.max' => 'Each image must not be greater than 1024 KB.',
            'images.*.mimes' => 'Each image must be a JPG or PNG file.',
        ];
    }

    public function updatedImages()
    {
        try {
            foreach ($this->images as $index => $image) {
                $this->validateOnly("images.$index"); // Validate each image individually
            }
            $this->dispatch('imagesValidated');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->reset('images');
            $this->dispatch('postSaved', [
                'status' => 'error',
                'type' => 'validation',
                'message' => $e->validator->errors()->toArray()
            ]);
        }
    }

    public function savePost()
    {

        try {
            $this->validate();

            $attachments = [];
            if ($this->images) {
                foreach ($this->images as $image) {
                    $attachments[] = $image->store('uploads/posts', 'public');
                }
            }

            DB::beginTransaction();

            Post::create([
                'user_id' => auth()->user()->id,
                'content' => $this->post_content,
                'attachments' => $attachments
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
