<div class="feed-content-container {{ auth()->check() ? 'feed-content-container-padding' : '' }}">
    @livewire('image-viewer')
    @foreach ($posts as $index => $post)
        @livewire('post-item', ['post' => $post], key($post->id))
    @endforeach
</div>
