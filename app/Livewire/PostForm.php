<?php

namespace App\Livewire;

use App\Models\Attachment;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostForm extends Component
{
    use WithFileUploads;

    #[Rule((['required', 'string']))]
    public string $post_content;

    #[Rule(['nullable', 'sometimes', 'max: 5124'])]
    public $file;

    #[Rule(['nullable', 'array'])]
    public array $images = [];

    public $profile_pic;

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

    #[On('profilePicUploaded')]
    public function updatedProfilePic()
    {
        $this->profile_pic = Storage::url($this->profile_pic = auth()->user()->profile->profile_pic_path);
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

    public function removeImage($index)
    {
        if ($this->images[$index]) {
            unset($this->images[$index]);
            $this->images = array_values($this->images);
        }
    }

    public function resetFile()
    {
        $this->reset('file');
    }

    public function savePost()
    {

        try {
            $this->validate();

            DB::beginTransaction();

            $post = Post::create([
                'user_id' => auth()->user()->id,
                'content' => $this->post_content
            ]);

            if (!empty($this->images)) {
                foreach ($this->images as $image) {
                    Attachment::create([
                        'attachable_id' => $post->id,
                        'attachable_type' => 'post',
                        'path' => $image->store("uploads/posts/{$post->id}", 'public'),
                        'file_type' => 'image'
                    ]);
                }
            }

            if ($this->file) {
                Attachment::create([
                    'attachable_id' => $post->id,
                    'attachable_type' => 'post',
                    'path' => $this->file->storeAs("uploads/posts/{$post->id}", $this->file->getClientOriginalName(), 'public'),
                    'file_type' => 'file'
                ]);
            }

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
