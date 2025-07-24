<div class="profile-header-container" x-data="HeaderData">
    <div class="cover-container">
        <div class="cover-photo-container"
            @click="$wire.dispatch('open-image-viewer', {category: 'cover', category_id: null, id: {{ auth()->user()->id }}})">
            <img src="{{ $cover_photo_link }}" alt="cover-photo">
        </div>
        <button @click="$dispatch('open-modal', {  name: 'update-cover' })" x-ref="myButton"><i
                class="fa-solid fa-pen"></i></button>

        <x-modal name="update-cover" title="Update Cover Photo">
            <div class="update-cover-img-container cursor-pointer !mt-2">
                <div wire:loading wire:target="cover_photo" class="loading-container-backdrop">
                    <div class="loading-container">
                        <x-loader size="50" />
                        <p class="text-center text-white"> Loading...</p>
                    </div>
                </div>


                @if ($cover_photo)
                    <img src="{{ $cover_photo->temporaryUrl() }}"alt="cover-photo"
                        @click="$refs.coverFileInput.click()">
                @else
                    <img src="{{ Storage::url(auth()->user()->profile->cover_pic_path) }}" alt="cover-photo"
                        @click="$refs.coverFileInput.click()">
                @endif
            </div>

            <form class="mt-4 mb-2 px-1" wire:submit.prevent="uploadCoverPic" id="update-cover-pic-form">
                <button type="button" class="button-square-main-2 w-full !py-3"
                    @click="$refs.coverFileInput.click()"><i class="fa-solid fa-upload"></i> Upload New Cover
                    Photo</button>
                <x-form-input type="file" name="cover_photo" id="cover-photo" wire:model="cover_photo"
                    x-ref="coverFileInput" accept="image/jpeg, image/png" hidden />
                <x-form-error name="cover_photo" />
            </form>

            @slot('footer')
                <div class="float-right flex gap-2">
                    <button class="button-square-secondary-1" @click="$dispatch('close-modal')"
                        wire:click="resetCoverPic">Cancel</button>
                    <button class="button-square-main-1" @click="savePhotoHandler('cover')">Save</button>
                </div>
            @endslot

        </x-modal>
    </div>

    <div class="profile-info-container">

        <div class="profile-img-container" @mouseover="showProfilePicEditBtn = true"
            @mouseout="showProfilePicEditBtn = false">
            <div class="w-full h-full"
                @click="$wire.dispatch('open-image-viewer', {category: 'profile', category_id: null, id: {{ auth()->user()->id }}})">
                <img src="{{ $profile_photo_link }}" alt="profile-user">
            </div>
            <div class="edit-profile-img-btn-container" x-show="showProfilePicEditBtn" x-transition.50ms>
                <button class="edit-profile-img-btn"
                    @click="$dispatch('open-modal', {  name: 'update-profile-pic' })">Update Photo</button>
            </div>

            <x-modal name="update-profile-pic" title="Update Profile Photo">
                <div class="update-profile-img-container cursor-pointer !mt-2">
                    <div wire:loading wire:target="profile_photo" class="loading-container-backdrop">
                        <div class="loading-container">
                            <x-loader size="50" />
                            <p class="text-center text-white"> Loading...</p>
                        </div>
                    </div>


                    @if ($profile_photo && !$errors->has('profile_photo'))
                        <img src="{{ $profile_photo->temporaryUrl() }}"alt="cover-photo"
                            @click="$refs.coverFileInput.click()">
                    @else
                        <img src="{{ Storage::url(auth()->user()->profile->profile_pic_path) }}" alt="cover-photo"
                            @click="$refs.profilePicInput.click()">
                    @endif
                </div>

                <form class="mt-4 mb-2 px-1" id="update-profile-pic-form" wire:submit.prevent="uploadProfilePic"
                    @on:livewire-upload-error="uploadingError = true">
                    <button type="button" class="button-square-main-2 w-full !py-3"
                        @click="$refs.profilePicInput.click()"><i class="fa-solid fa-upload"></i> Upload New Profile
                        Picture</button>
                    <x-form-input type="file" name="profile_photo" id="profile-photo" wire:model="profile_photo"
                        x-ref="profilePicInput" accept="image/jpeg, image/png" hidden />
                    <x-form-error name="profile_photo" />
                </form>


                @slot('footer')
                    <div class="float-right flex gap-2">
                        <button class="button-square-secondary-1" @click="cancelProfilePic"
                            wire:click="resetProfilePic">Cancel</button>
                        <button class="button-square-main-1" @click="savePhotoHandler('profile')">Save</button>
                    </div>
                @endslot
            </x-modal>
        </div>

        <div class="profile-text-container">
            <div class="flex flex-col">
                <p class="profile-name">{{ $name }}
                </p>
                <p class="profile-username">{{ '@' . $username }}</p>
            </div>
            <div class="flex flex-col">
                <p><b>1.25k</b> Followers</p>
                <p><b>1.25k</b> Following</p>
            </div>
        </div>


    </div>


</div>

@push('scripts')
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("HeaderData", () => ({
                showProfilePicEditBtn: false,
                uploadingError: false,
                cancelProfilePic() {
                    this.$dispatch('close-modal');
                    this.uploadingError = false;
                },
                savePhotoHandler(type) {
                    const form = type === "cover" ? document.getElementById("update-cover-pic-form") :
                        document.getElementById("update-profile-pic-form")

                    if (!this.uploadingError) {
                        return Notiflix.Report.failure(
                            `Error saving ${type} picture`,
                            "<p class='text-center'>Please upload the image in proper format and size.</p>",
                            "Okay"
                        );
                    }


                    Notiflix.Confirm.show(
                        "Attention!",
                        `Are you sure you want to update your ${type} picture?`,
                        "Sure, go!",
                        "No",
                        () => {
                            Notiflix.Loading.standard("Saving Picture. Please wait...");
                            form.requestSubmit();
                        },
                        () => null, {}
                    );
                }
            }))
        });

        const updatedPhotoHandler = (event) => {
            const {
                status,
                message
            } = event.detail[0];

            Notiflix.Loading.remove();

            // Dispatch Alpine event manually from global scope
            document.dispatchEvent(new CustomEvent("close-modal", {
                bubbles: true
            }));

            if (status === "success") {
                Notiflix.Notify.success(message, {
                    position: "right-bottom"
                });
            } else {
                Notiflix.Notify.failure(message, {
                    position: "right-bottom"
                });
            }
        }

        window.addEventListener("coverUploaded", updatedPhotoHandler)
        window.addEventListener("profilePicUploaded", updatedPhotoHandler);
    </script>
@endpush
