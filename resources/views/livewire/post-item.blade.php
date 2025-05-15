<div class="post-container"
    x-data='{
            editedCaption: @json($post->content),
            originalCaption: @json($post->content),
            editMode: false,
            openOptions: false,
            handleDelete() {
                Notiflix.Confirm.show(
                    "Attention!",
                    "Are you sure you want to delete this joke? (This action is irreversable)",
                    "Sure, go!",
                    "No",
                    () => {
                        Notiflix.Loading.standard("Deleting Post. Please wait...");
                        $wire.destroy();
                    }
                );
            },
            handleEdit() {
                if (this.editedCaption !== this.originalCaption) {
                    Notiflix.Confirm.show(
                        "Attention!",
                        "Are you sure you want to update this joke? (This action is irreversable)",
                        "Sure, go!",
                        "No",
                        () => {
                            this.editMode = false;
                            Notiflix.Loading.standard("Updating Post. Please wait...");
                            $wire.update();
                        }
                    );
                } else {
                    Notiflix.Notify.info("The edited caption is similar to the original caption", { position: "right-bottom", closeButton: true });
                    this.editMode = false;
                }
            }
        }'>
    <div class="flex justify-between items-center">
        <div class="user-info-post-container">
            {{-- User posted --}}
            <div class="sm-image-container">
                <img src="https://picsum.photos/42" alt="user-name">
            </div>
            <div class="flex flex-col align-items-center justify-center">
                <p class="font-bold post-name">{{ ucwords($post->user->first_name . ' ' . $post->user->last_name) }}</p>
                <p class="font-light post-time">{{ $time_posted }}</p>
            </div>
        </div>

        @auth
            @if ($post->user_id === auth()->user()->id)
                <div class="post-more-options-container">
                    <button class="post-more-option" @click="openOptions = !openOptions;" @click.away="openOptions = false"
                        :class="{ 'post-more-option-active': openOptions }">
                        <i class="fa-solid fa-ellipsis text-lg"></i>
                    </button>
                    <div class="post-more-option-content shadow-lg" x-show="openOptions" x-transition x-cloak>
                        <button @click="editMode = true">Edit Text</button>
                        <button @click="handleDelete">Delete</button>
                    </div>
                </div>
            @endif
        @endauth

    </div>

    <div class="text-sm mb-3">
        <p x-show="!editMode">
            {{-- content --}}
            {{ $text_content }}
        </p>

        @auth
            @if ($post->user_id === auth()->user()->id)
                <form class="post-edit-form shadow-lg" id="update-post-container" wire:submit.prevent x-show="editMode"
                    x-cloak>
                    <div class="post-input-edit-container">
                        <textarea name="edit_content" id="edit_content" wire:model="text_content" placeholder="Enter your post caption here..."
                            x-model="editedCaption"></textarea>
                    </div>
                    <div class="edit-buttons-container">
                        <button class="submit-btn" type="button" @click="handleEdit">Update</button>
                        <button class="cancel-btn" @click="editMode = false" type="button">Cancel</button>
                    </div>
                </form>
            @endif
        @endauth

    </div>


    @if ($images->isNotEmpty())
        @if ($images->count() === 1)
            <div class="images-max-height post-image shadow-lg">
                <img src="{{ asset('storage/' . $images->first()->path) }}" alt="image-{{ $post->id }}"
                    @click="$wire.dispatch('open-image-viewer', {category: 'post', category_id: {{ $post->id }}, id: {{ $images->first()->id }} })" />
            </div>
        @elseif($images->count() === 2)
            <div class="post-images-container-2 images-max-height">
                @foreach ($images as $index => $image)
                    <div class="shadow-lg post-image">
                        <img src="{{ asset('storage/' . $image->path) }}"
                            alt="image-{{ $post->id }}-{{ $index }}"
                            @click="$wire.dispatch('open-image-viewer', {category: 'post', category_id: {{ $post->id }}, id: {{ $image->id }} })" />
                    </div>
                @endforeach
            </div>
        @else
            <div class="post-images-container-3 images-max-height">

                @foreach ($images->take(3) as $index => $image)
                    <div class="shadow-lg post-image {{ $index === 0 ? 'first-image' : '' }} {{ $index === 2 && $images->count() > 3 ? 'more-image-overlay' : '' }}"
                        @click="$wire.dispatch('open-image-viewer', {category: 'post', category_id: {{ $post->id }}, id: {{ $image->id }} })">
                        <img src="{{ asset('storage/' . $image->path) }}"
                            alt="image-{{ $post->id }}-{{ $index }}" />
                        @if ($index === 2 && $images->count() > 3)
                            <p class="more-image-number">+{{ $images->count() - 3 }}</p>
                        @endif
                    </div>
                @endforeach

            </div>
        @endif

    @endif
    @if ($file)
        <div class="post-attachment-container">
            <div class="attachment-content">
                <div>
                    <p class="font-bold">{{ $file->title() }}</p>
                    <p class="text-xs">{{ $file->size() }}</p>
                </div>
                <div>
                    {{-- insert view --}}
                    <button type="button" wire:click="downloadFile({{ $file->id }})"
                        class="w-10 h-10 bg-blue-500 brightness-90 hover:brightness-100 rounded text-white">
                        <i class="fa-solid fa-file-arrow-down"></i>
                    </button>
                </div>

            </div>
        </div>
    @endif

    @auth()
        <div class="other-post-buttons-container">
            {{-- buttons --}}
            <button><i class="fa-regular fa-face-laugh-squint"></i> <span class="text-sm">Haha</span></button>
            <button><i class="fa-regular fa-comment"></i> <span class="text-sm">Comment</span></button>
            <button><i class="fa-solid fa-share"></i> <span class="text-sm">Share</span></button>
        </div>
        {{-- comments-container --}}
        {{-- <div>
        <div class="ms-4 ">
            <div class="other-comment-content">
                <div class="xs-image-container"><img src="https://picsum.photos/32"
                        alt="other-user-comment"></div>
                <div class="flex-1">
                    <p class="other-comment-name"><b>Lorem Ipsum</b></p>
                    <p class="other-comment">Lorem ipsum dolor sit amet consectetur. In sed felis quis
                        mi sit sed pharetra mauris
                        lacus. Lectus morbi quis dolor tristique nisl in lorem. Vitae sed ut risus elit
                        urna
                        id praesent netus tellus. Velit in nec nisl proin.</p>
                    <p class="other-comment-time">5 minutes ago</p>
                </div>
            </div>
            <div class="other-post-buttons-container ms-8">
                <button><i class="fa-regular fa-face-laugh-squint"></i> <span
                        class="text-sm">Haha</span></button>
                <button><i class="fa-regular fa-comment"></i> <span
                        class="text-sm">Comment</span></button>
            </div>
        </div>
    </div> --}}
        <div class="post-comment-container">
            {{-- comment-container --}}
            <div class="comment-text-container">
                <div class="xs-image-container"><img src="https://picsum.photos/32" alt="user-comment">
                </div>
                <textarea name="" id="" placeholder="Here's my comment..."></textarea>
                <button><i class="fa-solid fa-arrow-right"></i></button>
            </div>
            <div></div>
        </div>
    @endauth
</div>
