<form class="add-post-container" id="add-post-container" wire:submit.prevent="savePost" x-data="{ imageCount: 0 }">
    <div>
        <div class="post-input-container">
            <div>
                <div class="xs-image-container"><img src="https://picsum.photos/32" alt="user-post"></div>
            </div>
            <textarea name="post_content" id="post-content" value="{{ old('post_content') }}" placeholder="Make us laugh..."
                rows="3" wire:model="post_content"></textarea>

        </div>

        {{-- Preview --}}
        <div wire:loading wire:target="images" class="w-full border-b p-4 border-black">
            <div class="flex gap-3">
                <template x-for="i in imageCount" :key="i">
                    <div class="flex justify-center items-center w-28 h-28 rounded-lg bg-gray-500">
                        <x-loader />
                    </div>
                </template>
            </div>
        </div>
        @if (!empty($images) && !$errors->has('images'))
            <div class="flex border-b border-black gap-3 p-4" wire:loading.remove wire:target="images">
                @foreach ($images as $image)
                    <div class="flex justify-center items-center w-28 h-28 rounded-lg overflow-hidden shadow border">
                        <img src="{{ $image->temporaryUrl() }}" class="w-full h-full" alt="preview">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="post-buttons-container">
        <div class="attachment-buttons">
            <button type="button" @click="$refs.imageInput.click()"><i class="fa-regular fa-image"></i> Image</button>
            <input type="file" @change="imageCount = $refs.imageInput.files.length" x-ref="imageInput"
                wire:model="images" accept="image/jpg, image/png" hidden multiple>
            <button type="button" @click="$refs.fileInput.click()"><i class="fa-solid fa-paperclip"></i> File</button>
            <input type="file" x-ref="fileInput" wire:model="file" accept="pdf, .doc,.docx" hidden>

        </div>
        <div>
            <button class="submit-button" type="button" @click="handlePostSubmit()" wire:loading.attr='disabled' wire:target='images'>Post</button>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        const postForm = document.getElementById("add-post-container");

        function handlePostSubmit() {
            Notiflix.Confirm.show(
                "Attention!",
                "Are you sure you want to post this joke?",
                "Sure, go!",
                "No",
                () => {
                    Notiflix.Loading.standard("Saving Post. Please wait...");
                    postForm.requestSubmit();
                },
                () => null, {}
            );
        }

        window.addEventListener("postSaved", (event) => {
            const {
                status,
                message
            } = event.detail[0];

            Notiflix.Loading.remove();
            if (status === "success") {
                Notiflix.Notify.success(message, {
                    position: "right-bottom"
                });
            } else if (status === "error") {
                const {
                    type
                } = event.detail[0];

                if (type === 'validation') {
                    Object.values(message).forEach(errors => {
                        errors.forEach(error => {
                            Notiflix.Notify.failure(error, {
                                clickToClose: true,
                                position: "right-bottom",
                                closeButton: true
                            });
                        })
                    });
                } else {
                    Notiflix.Notify.failure(message, {
                        position: "right-bottom"
                    });
                }

            }
        });
    </script>
@endpush
