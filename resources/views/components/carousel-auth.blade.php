@push('styles')
    @vite('resources/css/components/auth_carousel.css')
@endpush

<div class="highlights-container swiper mySwiper">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <img src="{{ asset('assets/carousel/1.png') }}" alt="Social Media Newsfeed Experience">
        </div>
        <div class="swiper-slide">
            <img src="{{ asset('assets/carousel/2.png') }}" alt="Engage and Laugh with Other People">
        </div>
        <div class="swiper-slide">
            <img src="{{ asset('assets/carousel/3.png') }}" alt="Create and Post Jokes">
        </div>
        <div class="swiper-slide">
            <img src="{{ asset('assets/carousel/4.png') }}" alt="Daily Jokes">
        </div>
        <div class="swiper-slide">
            <img src="{{ asset('assets/carousel/5.png') }}" alt="Fun and Enjoyable Community">
        </div>
    </div>
    <div class="swiper-pagination"></div>
</div>

@push('scripts')
    @vite('resources/js/components/auth_carousel.js')
@endpush
