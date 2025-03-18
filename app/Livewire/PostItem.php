<?php

namespace App\Livewire;

use App\Models\Post;
use Carbon\Carbon;
use Livewire\Component;

class PostItem extends Component
{
    public Post $post;


    public function render()
    {
        $time_posted = Carbon::parse($this->post->created_at);

        $time_difference = $time_posted->diffInSeconds(now());
        $unit = $time_difference > 1 ? 'seconds ago' : 'second ago';

        if ($time_difference >= 60 * 60 * 24) {
            $time_difference = $time_posted->diffInDays(now());
            $unit = $time_difference > 1 ? 'days ago' : 'day ago';
        } else if ($time_difference >= 60 * 60) {
            $time_difference = $time_posted->diffInHours(now());
            $unit = $time_difference > 1 ? 'hours ago' : 'hour ago';
        } else if ($time_difference >= 60) {
            $time_difference = $time_posted->diffInMinutes(now());
            $unit = $time_difference > 1 ? 'minutes ago' : 'minute ago';
        }

        $time_difference_text = floor($time_difference) . ' ' . $unit;

        return view('livewire.post-item', [
            'time_posted' => $time_difference_text
        ]);
    }
}
