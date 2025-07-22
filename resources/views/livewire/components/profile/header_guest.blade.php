<div class="profile-header-container" x-data="{ showProfilePicEditBtn: false }">
    <div class="cover-container">
        <div class="cover-photo-container"
            @if ($has_cover_pic) @click="$wire.dispatch('open-image-viewer', {category: 'cover', category_id: null, id: {{ $user->id }}})" @endif>
            <img src="{{ $cover_photo_link }}" alt="cover-photo">
        </div>
    </div>

    <div class="profile-info-container">

        <div class="profile-img-container" @mouseover="showProfilePicEditBtn = true"
            @mouseout="showProfilePicEditBtn = false">
            <div class="w-full h-full"
                @if ($has_profile_pic) @click="$wire.dispatch('open-image-viewer', {category: 'profile', category_id: null, id: {{ $user->id }}})" @endif>
                <img src="{{ $profile_photo_link }}" alt="profile-user">
            </div>
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
        const saveCoverPic = () => savePhotoHandler("cover");
        const saveProfilePic = () => savePhotoHandler("profile");

        const savePhotoHandler = (type) => {
            const form = type === "cover" ? document.getElementById("update-cover-pic-form") : document.getElementById(
                "update-profile-pic-form")

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


        // window.addEventListener("profilePicUploaded", (event) => {
        //     const {
        //         status,
        //         message
        //     } = event.detail[0];

        //     // reset alpine variables
        //     if (window.postFormComponent) {
        //         window.postFormComponent.resetFile();
        //     }

        //     // Dispatch Alpine event manually from global scope
        //     document.dispatchEvent(new CustomEvent("close-modal", {
        //         bubbles: true
        //     }));

        //     if (status === "success") {
        //         Notiflix.Notify.success(message, {
        //             position: "right-bottom"
        //         });
        //     } else {
        //         Notiflix.Notify.failure(message, {
        //             position: "right-bottom"
        //         });
        //     }
        // });
    </script>
@endpush
