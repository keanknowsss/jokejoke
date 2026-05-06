@props(['title' => '', 'name'])

@pushOnce('styles')
    @vite('resources/css/components/modal.css')
@endPushOnce

<div
    class="modal-component"
    x-data="{ open: false, name: '{{ $name }}' }"
    @open-modal.window = "
        if ($event.detail.name === name) {
            open = true;
            {{-- hide scroll and adjust layout for scrollbar --}}
            const sw = window.innerWidth - document.documentElement.clientWidth;
            document.body.style.overflow = 'hidden';
            document.body.style.paddingRight = sw + 'px';
        }
    "
    @close-modal.window = "
        open = false;
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    "
    x-show="open" x-cloak>
    <div class="modal-backdrop" @click = "window.dispatchEvent(new CustomEvent('close-modal'))"></div>

    <div class="modal-container" x-show="open" x-transition>
        <div class="modal-header">
            <span class="title">{{ $title ?? '' }}</span>
            <button class="modal-exit-btn" @click = "window.dispatchEvent(new CustomEvent('close-modal'))">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @if (isset($slot))
            <div class="modal-body">
                {{ $slot }}
            </div>
        @endif

        @if (isset($footer))
            <div class="modal-footer">
                {{ $footer }}
            </div>
        @endif
    </div>

</div>
