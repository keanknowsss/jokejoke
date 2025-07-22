<div id="about-container" class="about-container">
    <div class="about-info">
        <div class="flex justfy-between w-full">
            <div class="w-1/2 pr-5">
                <p class="font-bold">Username</p>
                <p>{{ $username }}</p>
            </div>
            <div class="w-1/2">
                <p class="font-bold">Date joined</p>
                <p>{{ $date_joined }}</p>
            </div>
        </div>
        <div>
            <p class="font-bold">Full Name</p>
            <p>{{ $first_name . ' ' . $last_name }}</p>
        </div>
        <div>
            <p class="font-bold">Birthday</p>
            <p class="{{ $birthdate ? '' : 'text-gray' }}">{{ $birthdate ?? 'Not Set' }}</p>
        </div>
        <div>
            <p class="font-bold">Email Address</p>
            <p>{{ $email }}</p>
        </div>
        <div>
            <p class="font-bold">Bio</p>
            <p class="{{ $bio ? '' : 'text-gray' }}">{{ $bio ?? 'Not set' }}</p>
        </div>
    </div>
</div>
