<?php

namespace App\Livewire;

use App\Models\Attachment;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class ImageViewer extends Component
{
    public string $category_id = '', $id = '';
    public array $images = [];


    /**
     * Loads images based on the specified category and identifiers.
     *
     * @param string $category The category type, e.g., 'post'.
     * @param string $category_id The identifier for the category.
     * @param string $id The identifier for the specific image.
     * @return void
     */
    #[On('open-image-viewer')]
    public function loadImages(string $category, string $category_id, string $id)
    {

        if ($category === 'post') {
            $current_image = Attachment::where('id', $id)
                ->get()
                ->map(fn($image) => $image->path = Storage::url($image->path))
                ->first();

            $images = Post::find($category_id)
                ->attachments()
                ->where('file_type', 'image')
                ->whereNot('id', $id)
                ->get()
                ->map(fn($image) => $image->path = Storage::url($image->path))
                ->toArray();

            array_unshift($images, $current_image);
            $this->images = $images;
        }

        $this->dispatch('image-loaded');

    }

    public function render()
    {
        return view('livewire.image-viewer');
    }
}
