<form class="add-post-container" id="add-post-container" wire:submit.prevent="savePost" x-data="postForm()">
    <div>
        <div class="post-input-container">
            <div>
                <div class="xs-image-container border shadow">
                    <img src="{{ $profile_pic }}" alt="user-post">
                </div>
            </div>
            <textarea name="post_content" id="post-content" value="{{ old('post_content') }}" placeholder="Make us laugh..."
                rows="3" wire:model="post_content"></textarea>

        </div>

        {{-- Image --}}
        <div wire:loading wire:target="images" class="w-full border-b p-4 border-black">
            <div class="flex gap-3">
                <template x-for="i in imageCount" :key="i">
                    <div class="flex justify-center items-center w-36 h-40 rounded-lg bg-gray-500">
                        <x-loader />
                    </div>
                </template>
            </div>
        </div>
        @if (!empty($images) && !$errors->has('images'))
            <div class="flex border-b border-black gap-3 p-4" wire:loading.remove wire:target="images">
                @foreach ($images as $index => $image)
                    <div
                        class="flex justify-center items-center w-36 h-40 rounded-lg overflow-hidden shadow border relative">
                        <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover" alt="preview">
                        <button type="button"
                            class="shadow absolute top-1 right-1 h-8 w-8 text-sm rounded-full bg-gray-400 brightness-90 hover:brightness-100 transition-all duration-100"
                            wire:click="removeImage({{ $index }})">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- File --}}
        <div class="post-file-preview-container shadow" x-show="showFile" x-cloak>
            <div class="attachment-content">
                <div>
                    <p class="font-bold" x-text="fileName"></p>
                    <p class="text-xs" x-text="fileSize"></p>
                </div>
                <div>
                    {{-- insert view or download button here --}}
                    <button type="button"
                        class="w-10 h-10 bg-red-500 brightness-90 hover:brightness-100 rounded text-gray-100"
                        wire:click="resetFile()" @click="resetFile()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="post-buttons-container">
        <div class="attachment-buttons">
            <button type="button" @click="$refs.imageInput.click()"><i class="fa-regular fa-image"></i> Image</button>
            <input type="file" @change="imageCount = $refs.imageInput.files.length" x-ref="imageInput"
                wire:model="images" accept="image/jpg, image/png" hidden multiple>

            <button type="button" @click="$refs.fileInput.click()"><i class="fa-solid fa-paperclip"></i> File</button>
            <input type="file" x-ref="fileInput" wire:model="file" @change="handleFile(event)"
                accept=".pdf, .doc, .docx" hidden>
        </div>
        <div>
            <button class="submit-button" type="button" @click="handlePostSubmit()" wire:loading.attr='disabled'
                wire:target='images'>Post</button>
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

        document.addEventListener("alpine:init", () => {
            Alpine.data("postForm", () => ({
                imageCount: 0,
                showFile: false,
                fileName: '',
                fileURL: '',
                fileSize: '',

                handleFile(event) {

                    const file = event.target.files[0];

                    if (file) {
                        this.showFile = true;
                        this.fileName = file.name;
                        this.fileURL = URL.createObjectURL(file);

                        // defaults to MB
                        let size = (file.size / (1024 * 1024)).toFixed(2);

                        // converts to KB if smol
                        if (size < 1) {
                            size *= 1024;
                            this.fileSize = `${size} KB`;
                        } else {
                            this.fileSize = `${size} MB`;
                        }

                    }
                },
                resetFile() {
                    this.showFile = false;
                    this.fileName = '';
                    this.fileURL = '';
                    this.fileSize = '';
                },

                init() {
                    // Store Alpine reference globally
                    window.postFormComponent = this;
                }
            }));
        });

        window.addEventListener("postSaved", (event) => {
            const {
                status,
                message
            } = event.detail[0];

            Notiflix.Loading.remove();

            // reset alpine variables
            if (window.postFormComponent) {
                window.postFormComponent.resetFile();
            }

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
