<div class="feed-content-container {{ auth()->check() ? 'feed-content-container-padding' : '' }}">
    @foreach ($posts as $index => $post)
        @livewire('post-item', ['post' => $post], key($post->id))
    @endforeach
</div>

@push('scripts')
    <script>
        // Handle Response
        window.addEventListener("postDeleted", function(event) {
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
                Notiflix.Notify.failure(message, {
                    position: "right-bottom",
                });
            }
        });

        window.addEventListener("postUpdated", function(event) {
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
