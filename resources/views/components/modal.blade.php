@props(['title' => '', 'name'])

@pushOnce('styles')
    @vite('resources/css/components/modal.css')
@endPushOnce

<div class="modal-component" x-data="{ open: false, name: '{{ $name }}' }" @open-modal.window = "open = $event.detail.name === name"
    @close-modal.window = "open = false" x-show="open" x-cloak>
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
