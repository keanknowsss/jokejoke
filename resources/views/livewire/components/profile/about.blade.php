<form id="about-container" class="about-container" wire:submit.prevent="update" x-data="{
    aboutEdit: false,
    init() {
        window.profileFormComponent = this;
        if (@json(!$has_profile)) {
            this.aboutEdit = true;
        }
    },
    reset() {
        this.aboutEdit = false
    }
}">
    <div class="about-info">
        <div class="flex justfy-between w-full">
            <div class="w-1/2 pr-5">
                <div x-show="!aboutEdit">
                    <p class="font-bold">Username</p>
                    <p>{{ $username }}</p>
                </div>
                <div x-show="aboutEdit" x-cloak>
                    <x-form-label for="username" class="font-bold">Username</x-form-label>
                    <x-form-input class="!rounded !p-3" type="text" wire:model="username" name="username"
                        id="username" placeholder="Enter your username here" required />
                    <x-form-error name="username" />
                </div>
            </div>
            <div class="w-1/2">
                <div x-show="!aboutEdit">
                    <p class="font-bold">Date joined</p>
                    <p x-show="!aboutEdit">{{ $date_joined }}</p>
                </div>
                <div x-show="aboutEdit" x-cloak>
                    <x-form-label for="date-joined" class="font-bold">Date joined</x-form-label>
                    <x-form-input class="!rounded !p-3" type="text" wire:model="date_joined" name="date_joined"
                        id="date-joined" disabled />
                </div>
            </div>
        </div>
        <div>
            <div x-show="!aboutEdit">
                <p class="font-bold" x-show="!aboutEdit">Full Name</p>
                <p>{{ $first_name . ' ' . $last_name }}</p>
            </div>
            <div class="flex justfy-between w-full" x-show="aboutEdit" x-cloak>
                <div class="w-1/2 pr-5">
                    <x-form-label for="first-name" class="font-bold">First Name</x-form-label>
                    <x-form-input class="!rounded !p-3 w-1/2 pr-5" type="text" wire:model="first_name"
                        name="first_name" id="first-name" placeholder="Enter your first name here" required />
                    <x-form-error name="first_name" />
                </div>
                <div class="w-1/2">
                    <x-form-label for="last-name" class="font-bold">Last Name</x-form-label>
                    <x-form-input class="!rounded !p-3 w-1/2 pr-5" type="text" wire:model="last_name"
                        name="last_name" id="last-name" placeholder="Enter your last name here" required />
                    <x-form-error name="last_name" />
                </div>

            </div>
        </div>
        <div>
            <div x-show="!aboutEdit">
                <p class="font-bold">Birthday</p>
                <p>{{ $birthdate }}</p>
            </div>
            <div x-show="aboutEdit" x-cloak>
                <x-form-label for="birthdate" class="font-bold">Birthday</x-form-label>
                <x-form-input class="!rounded !p-3" type="date" wire:model="birthdate" name="birthdate"
                    id="birthdate" required />
                <x-form-error name="birthdate" />
            </div>
        </div>
        <div>
            <div x-show="!aboutEdit">
                <p class="font-bold">Email Address</p>
                <p>{{ $email }}</p>
            </div>
            <div x-show="aboutEdit" x-cloak>
                <x-form-label for="email" class="font-bold">Email Address</x-form-label>
                <x-form-input class="!rounded !p-3" type="email" wire:model="email" name="email" id="email"
                    required />
                <x-form-error name="email" />
            </div>
        </div>
        <div>
            <div x-show="!aboutEdit">
                <p class="font-bold">Bio</p>
                <p>{{ $bio }}</p>
            </div>
            <div x-show="aboutEdit" x-cloak>
                <x-form-label for="bio" class="font-bold">Bio</x-form-label>
                <x-form-input class="!rounded !p-3" type="textarea" wire:model="bio" name="bio" id="bio" />
                <x-form-error name="bio" />
            </div>
        </div>
        <div class="profile-edit-btn-container" x-show="aboutEdit" x-transition x-cloak>
            <button class="save-btn" @click="handleUpdateAbout" type="button">Save</button>
            @if ($has_profile)
                <button class="cancel-btn" @click="aboutEdit = false" type="button" wire:click="loadUserData()">Cancel</button>
            @endif
        </div>
    </div>
    <div>
        <button class="edit-btn" @click="aboutEdit = true" x-show="!aboutEdit" type="button">Edit</button>
    </div>
</form>

@push('scripts')
    <script>
        const userInformationForm = document.getElementById("about-container");

        function handleUpdateAbout() {
            if (!userInformationForm.checkValidity()) {
                return userInformationForm.reportValidity();
            }

            Notiflix.Confirm.show(
                "Attention!",
                "Do you want to save the changes in your user information?",
                "Yeah, sure!",
                "No",
                () => {
                    Notiflix.Loading.standard("Saving changes. Please wait...");
                },
                () => null, {}
            )
        }

        window.addEventListener("updatedAbout", (event) => {
            const {
                status,
                message
            } = event.detail[0];

            Notiflix.Loading.remove();

            // reset alpine variables
            if (window.profileFormComponent) {
                window.profileFormComponent.reset();
            }

            if (status === "success") {
                Notiflix.Notify.success(message, {
                    position: "right-bottom"
                });
            } else if (status === "empty") {
                Notiflix.Notify.info(message, {
                    position: "right-bottom"
                });
            } else if (status === "error") {
                Notiflix.Notify.failure(message, {
                    position: "right-bottom"
                });
            }

        });
    </script>
@endpush
