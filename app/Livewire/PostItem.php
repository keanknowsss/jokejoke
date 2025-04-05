<?php

namespace App\Livewire;

use App\Models\Attachment;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Component;

class PostItem extends Component
{
    public Post $post;

    #[Rule(['required', 'string'])]
    public string $text_content;

    public function mount(Post $post) {
        $this->text_content = $post->content;
    }

    public function downloadFile($attachment_id) {
        try {
            $attachment = Attachment::findOrFail($attachment_id);
            $path = $attachment->path;

            if (!Storage::disk('public')->exists($path)) {
                abort(404, 'File not found');
            }

            return Storage::disk('public')->download($path);

        } catch (\Throwable $th) {
            session()->flash('error', 'Error downloading file');
        }
    }

    public function destroy() {
        try {
            $this->post->delete();
            $this->dispatch('postDeleted', [
                'status' => 'success',
                'message' => 'Post is deleted successfully'
            ]);
        } catch (\Throwable $th) {
            $this->dispatch('postDeleted', [
                'status' => 'error',
                'message' => 'Something went wrong. Please try again.'
            ]);
        }
    }

    public function update() {
        try {
            $this->validate();

            DB::beginTransaction();

            $this->post->content = $this->text_content;
            $this->post->save();

            DB::commit();

            $this->dispatch('postUpdated', [
                'status' => 'success',
                'message' => 'Post successfully updated'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // validation error
            $this->dispatch('postUpdated', [
                'status' => 'error',
                'type' => 'validation',
                'message' => $e->validator->errors()->toArray()
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('postUpdated', [
                'status' => 'error',
                'type' => 'error',
                'message' => 'Something went wrong. Please try again.'
            ]);
        }
    }

    public function render()
    {
        $time_posted = Carbon::parse($this->post->created_at);

        $time_difference = $time_posted->diffInSeconds(now());
        $unit = floor($time_difference) > 1 ? 'seconds ago' : 'second ago';

        if ($time_difference >= 60 * 60 * 24) {
            $time_difference = $time_posted->diffInDays(now());
            $unit = floor($time_difference) > 1 ? 'days ago' : 'day ago';
        } else if ($time_difference >= 60 * 60) {
            $time_difference = $time_posted->diffInHours(now());
            $unit = floor($time_difference) > 1 ? 'hours ago' : 'hour ago';
        } else if ($time_difference >= 60) {
            $time_difference = $time_posted->diffInMinutes(now());
            $unit = floor($time_difference) > 1 ? 'minutes ago' : 'minute ago';
        }

        $time_difference_text = floor($time_difference) . ' ' . $unit;

        return view('livewire.post-item', [
            'time_posted' => $time_difference_text,
            'file' => $this->post->attachments()->where('file_type', 'file')->first(),
            'images' => $this->post->attachments()->where('file_type', 'image')->get()
        ]);
    }
}
