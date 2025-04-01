<div class="image-display-container"
    x-data="{
        open: false,
        loading: true,
        closeViewer() {
            this.open = false;
            document.body.style.overflow = 'auto';
            setTimeout(() => this.loading = true, 300);
        }
    }"
    @click="closeViewer"
    x-show="open"
    @open-image-viewer.window="open = true; loading = true;" @image-loaded.window="loading = false;">

    <button class="hide-image-btn" @click="closeViewer">
        <i class="fa-solid fa-circle-xmark"></i>
    </button>

    <div x-show="!loading" class="image-display" @click.stop x-transition
        x-bind:class="{ 'opacity-100 scale-100': open, 'opacity-0 scale-90': !open }" x-transition>

        <img src="{{ $src }}" alt="image preview {{ $id }}">

    </div>

    <div x-show="loading">
        <x-loader size="50" />
        <p class="text-center text-white"> Loading...</p>
    </div>
</div>
