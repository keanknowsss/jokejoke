<?php

namespace App\Livewire;

use App\Models\Attachment;
use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Component;

class ImageViewer extends Component
{
    public string $category_id = '', $src = '', $id = '';
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
    public function loadImages(string $category, string $category_id, string $id) {

        if ($category === 'post') {
           $current_image =  Attachment::select('id', 'path')->where('id', $id)->first();
           $this->src = asset("storage/$current_image->path");

           $images = Post::find($category_id)
            ->attachments()
            ->select('id', 'path')
            ->where('file_type', 'image')
            ->whereNot('id', $id)
            ->get()->toArray();

            array_unshift($images, $current_image->toArray());
            $this->images = $images;

        }

        $this->dispatch('image-loaded');

    }

    public function render()
    {
        return view('livewire.image-viewer');
    }
}
