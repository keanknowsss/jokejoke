@push('styles')
    @vite('resources/css/components/image_viewer.css')
@endpush

<div class="image-display-container"
    x-data="{
        open: false,
        loading: true,
        images: [],
        closeViewer() {
            this.open = false;
            document.body.style.overflow = 'auto';
            setTimeout(() => this.loading = true, 300);
        },
        openViewer() {
            this.open = true;
            this.loading = true;
            this.images = [];
            document.body.style.overflow = 'hidden';

            $nextTick(() => { $el.focus(); });
        },
        moveLeft() {
            this.images.unshift(this.images.pop());
        },
        moveRight() {
            this.images.push(this.images.shift());
        }
    }"
    tabindex="0"
    @keydown.left="moveLeft"
    @keydown.right="moveRight",
    @keydown.esc="closeViewer",
    @click="closeViewer"
    x-show="open"
    @open-image-viewer.window="openViewer"
    @image-loaded.window="loading = false; images = $wire.images;"
    x-cloak
>

    <button class="hide-image-btn" @click="closeViewer">
        <i class="fa-solid fa-circle-xmark"></i>
    </button>

    <button x-show="!loading && images.length > 1" id="left-image-btn" class="shadow" @click.stop="moveLeft">
        <i class="fa-solid fa-angle-left"></i>
    </button>

    <button x-show="!loading && images.length > 1" id="right-image-btn" class="shadow" @click.stop="moveRight">
        <i class="fa-solid fa-angle-right"></i>
    </button>

    <div x-show="!loading" class="image-display" @click.stop x-transition
        x-bind:class="{ 'opacity-100 scale-100': open, 'opacity-0 scale-90': !open }" x-transition>

        <img x-show="images.length > 0" :src="images[0]" alt="image preview {{ $id }}">

    </div>

    <div x-show="loading">
        <x-loader size="50" />
        <p class="text-center text-white"> Loading...</p>
    </div>

</div>
