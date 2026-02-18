<div class="profile-header-container" x-data="HeaderData($wire)" x-init="init()">
    <div class="cover-container">
        <div class="cover-photo-container"
            @if ($user->profile?->cover_pic_path) @click="$wire.dispatch('open-image-viewer', {category: 'cover', category_id: null, id: {{ auth()->user()->id }}})">
            @else
                @click="$dispatch('open-modal', {  name: 'update-cover' })" @endif
            <img src="{{ $user->cover_pic }}" alt="cover-photo">
        </div>
        <button @click="$dispatch('open-modal', {  name: 'update-cover' })" x-ref="myButton"><i
                class="fa-solid fa-pen"></i></button>

        <x-modal name="update-cover" title="Update Cover Photo">
            @if ($user->profile?->profile_pic_path || $user->profile?->cover_pic_path)
                <div class="update-cover-img-container">
                    <div wire:loading wire:target="cover_photo" class="loading-container-backdrop">
                        <div class="loading-container">
                            <x-loader size="50" />
                            <p class="text-center text-white"> Loading...</p>
                        </div>
                    </div>

                    @if ($cover_photo && !$errors->has('cover_photo'))
                        <img src="{{ $cover_photo->temporaryUrl() }}"alt="cover-photo"
                            @click="$refs.coverFileInput.click()">
                    @else
                        <img src="{{ $user->cover_pic }}" alt="cover-photo" @click="$refs.coverFileInput.click()">
                    @endif

                </div>
            @else
                <div class="update-cover-img-container" wire:loading wire:target="cover_photo">
                    <div wire:loading wire:target="cover_photo" class="loading-container-backdrop">
                        <div class="loading-container">
                            <x-loader size="50" />
                            <p class="text-center text-white"> Loading...</p>
                        </div>
                    </div>
                </div>
                <div class="p-3 border border-black border-solid text-center rounded-lg cursor-pointer"
                    @click="$refs.coverFileInput.click()" wire:loading.class="hidden" wire:target="cover_photo">
                    No Cover Photo Yet.
                </div>
            @endif

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
                    <button class="button-square-secondary-1" @click="$dispatch('close-modal')">Cancel</button>
                    <button class="button-square-main-1" @click="savePhotoHandler('cover')">Save</button>
                </div>
            @endslot

        </x-modal>
    </div>

    <div class="profile-info-container">

        <div class="profile-img-container" @mouseover="showProfilePicEditBtn = true"
            @mouseout="showProfilePicEditBtn = false">
            <div class="w-full h-full"
                @if ($user->profile?->profile_pic_path) @click="$wire.dispatch('open-image-viewer', {category: 'profile', category_id: null, id: {{ auth()->user()->id }}})">
                @else
                    @click="$dispatch('open-modal', {  name: 'update-profile-pic' })" @endif
                <img src="{{ $user->profile_pic }}" alt="profile-user">
            </div>
            <div class="edit-profile-img-btn-container" x-show="showProfilePicEditBtn" x-transition.50ms>
                <button class="edit-profile-img-btn"
                    @click="$dispatch('open-modal', {  name: 'update-profile-pic' })">Update Photo</button>
            </div>

            <x-modal name="update-profile-pic" title="Update Profile Photo">
                @if ($user->profile?->profile_pic_path || $profile_photo)
                    <div class="update-profile-img-container">
                        <div wire:loading wire:target="profile_photo" class="loading-container-backdrop">
                            <div class="loading-container">
                                <x-loader size="50" />
                                <p class="text-center text-white"> Loading...</p>
                            </div>
                        </div>


                        @if ($profile_photo && !$errors->has('profile_photo'))
                            <img src="{{ $profile_photo->temporaryUrl() }}"alt="profile-photo"
                                @click="$refs.profilePicInput.click()">
                        @else
                            <img src="{{ $user->profile_pic }}" alt="profile-photo"
                                @click="$refs.profilePicInput.click()">
                        @endif
                    </div>
                @else
                    <div class="update-profile-img-container aspect-square hidden" wire:loading.class.remove="hidden"
                        wire:target="profile_photo">
                        <div class="loading-container-backdrop">
                            <div class="loading-container">
                                <x-loader size="50" />
                                <p class="text-center text-white"> Loading...</p>
                            </div>
                        </div>
                    </div>
                    <div wire:loading.class="hidden" wire:target="profile_photo"
                        class="p-3 border border-black border-solid text-center rounded-lg cursor-pointer"
                        @click="$refs.profilePicInput.click()">No Profile Photo Yet.</div>
                @endif


                <form class="mt-4 mb-2 px-1" id="update-profile-pic-form" wire:submit.prevent="uploadProfilePic">
                    <button type="button" class="button-square-main-2 w-full !py-3"
                        @click="$refs.profilePicInput.click()"><i class="fa-solid fa-upload"></i> Upload New Profile
                        Picture</button>
                    <x-form-input type="file" name="profile_photo" id="profile-photo" wire:model="profile_photo"
                        x-ref="profilePicInput" accept="image/jpeg, image/png" hidden />
                    <x-form-error name="profile_photo" />
                </form>


                @slot('footer')
                    <div class="float-right flex gap-2">
                        <button class="button-square-secondary-1" @click="$dispatch('close-modal')">Cancel</button>
                        <button class="button-square-main-1" @click="savePhotoHandler('profile')">Save</button>
                    </div>
                @endslot
            </x-modal>
        </div>

        <div class="profile-text-container">
            <div class="flex flex-col">
                <p class="profile-name">{{ $user->name }}
                </p>
                <p class="profile-username">{{ '@' . $user->username }}</p>
            </div>
            <div class="flex flex-col">
                <p><b>{{ auth()->user()->summary?->follower_count ?? 0 }}</b> Followers</p>
                <p><b>{{ auth()->user()->summary?->following_count ?? 0 }}</b> Following</p>
            </div>
        </div>


    </div>


</div>

@push('scripts')
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("HeaderData", ($wire) => ({
                init() {
                    window.addEventListener("livewire-upload-finish", () => {
                        this.uploadingError = $wire.uploading_error;
                        this.isReadyToUpload = ($wire.cover_photo !== null || $wire
                            .profile_photo !== null) && !this.uploadingError;
                    });
                    window.addEventListener("coverUploaded", this.updatedPhotoHandler)
                    window.addEventListener("profilePicUploaded", this.updatedPhotoHandler);
                    window.addEventListener("close-modal", this.cancelUpload);
                },
                showProfilePicEditBtn: false,
                uploadingError: false,
                isReadyToUpload: false,
                cancelUpload() {
                    this.uploadingError = false;
                    this.isReadyToUpload = false;
                    $wire.resetProfilePic();
                    $wire.resetCoverPic();
                },
                savePhotoHandler(type) {
                    const form = type === "cover" ? document.getElementById("update-cover-pic-form") :
                        document.getElementById("update-profile-pic-form")

                    const photoRef = type === 'cover' ? $wire.cover_photo : $wire.profile_photo;

                    if (!photoRef) {
                        return Notiflix.Report.failure(
                            `Error saving ${type} picture`,
                            `<p class='text-center'>Please upload a ${type} picture first</p>`,
                            "Okay"
                        );
                    }

                    if (this.uploadingError) {
                        return Notiflix.Report.failure(
                            `Error saving ${type} picture`,
                            "<p class='text-center'>Please upload the image in proper format and size.</p>",
                            "Okay"
                        );
                    }

                    if (!this.isReadyToUpload) {
                        return Notiflix.Report.info(
                            "Uploading not yet ready",
                            "<p class='text-center'>Please upload an image then wait for the preview before saving.</p>",
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
                },
                updatedPhotoHandler(event) {
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
            }))
        });
    </script>
@endpush
