{{-- Allows previewing of image --}}
<div x-data="{ display : false}" class="h-full" @keydown.window.escape="display = false; document.body.style.overflow = 'auto'">
    <img src="{{ $src }}" alt="{{ $alt }} image" class="cursor-pointer" @click="display = true; document.body.style.overflow = 'hidden'">

    <div class="image-display-container" x-show="display" x-cloak>
        <button class="hide-image-btn" @click="display = false; document.body.style.overflow = 'auto'">
            <i class="fa-solid fa-circle-xmark"></i>
        </button>
        <div class="image-display" x-show="display" x-transition @click.away="display = false; document.body.style.overflow = 'auto'"  x-bind:class="{ 'opacity-100 scale-100': display, 'opacity-0 scale-90': !display }" x-transition>
            <img src="{{ $src }}" alt="{{ $alt }} image preview">
        </div>
    </div>
</div>
