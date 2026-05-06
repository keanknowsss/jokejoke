@push('styles')
    @vite('resources/css/components/user_suggestion.css')
@endpush

<section class="suggestions-bar">
    @foreach ($users as $user)
        @livewire('user-card', ['user' => $user], key($user->id))
    @endforeach
</section>
