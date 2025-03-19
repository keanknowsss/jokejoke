<?php

namespace App\Livewire;

use App\Models\Attachment;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PostItem extends Component
{
    public Post $post;

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
            'image' => $this->post->attachments()->where('file_type', 'image')
        ]);
    }
}
