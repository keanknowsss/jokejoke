@push('styles')
    @vite('resources/css/components/sidebar.css')
@endpush

<section class="profile-bar">
    @auth

        <div class="profile-bar-content">
            <div class="user-info-container">
                <div class="sidebar-img">
                    <img src="https://picsum.photos/106" height="106" alt="user-profile">
                </div>
                <div>
                    <p class="font-bold text-center">{{ $fullname }}</p>
                    <p class="font-light text-center text-sm">{{ $username }}</p>
                </div>
            </div>
            <ul class="sidebar-navlinks">
                <div>
                    <li>
                        <a href="{{ route('home') }}">
                            <p><i class="fa-solid fa-house"></i> Home</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile') }}">
                            <p><i class="fa-solid fa-user"></i> Profile</p>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="#">
                            <p><i class="fa-solid fa-bell"></i> Notification</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <p><i class="fa-solid fa-gear"></i> Settings</p>
                        </a>
                    </li> --}}
                </div>
                <div>
                    <li>
                        <form action="{{ route('user.logout') }}" method="post">
                            @csrf
                            <p><button><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</button></p>
                        </form>
                    </li>
                </div>
            </ul>
        </div>

    @endauth
</section>
