<form class="add-post-container" id="add-post-container" wire:submit.prevent="savePost">
    <div class="post-input-container">
        <div>
            <div class="xs-image-container"><img src="https://picsum.photos/32" alt="user-post"></div>
        </div>
        <textarea name="post_content" id="post-content" value="{{ old('post_content') }}" placeholder="Make us laugh..." rows="3"
            wire:model="post_content"></textarea>
    </div>
    <div class="post-buttons-container">
        <div class="attachment-buttons">
            <button type="button"><i class="fa-solid fa-paperclip"></i> File</button>
            <button type="button" @click="$refs.fileInput.click()"><i class="fa-regular fa-image"></i> Image</button>
            <input type="file" wire:model="images" accept="image/jpg, image/png" x-ref="fileInput" hidden>
        </div>
        <div>
            <button class="submit-button" type="button" @click="handlePostSubmit()">Post</button>
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
                                timeout: 300000
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
