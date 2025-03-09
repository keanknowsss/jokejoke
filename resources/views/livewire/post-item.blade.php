<div class="post-container">
    <div class="user-info-post-container">
        {{-- User posted --}}
        <div class="sm-image-container">
            <img src="https://picsum.photos/42" alt="user-name">
        </div>
        <div class="flex flex-col align-items-center justify-center">
            <p class="font-bold post-name">{{ ucwords($post->user->first_name . ' ' . $post->user->last_name) }}</p>
            <p class="font-light post-time">2 hours ago</p>
        </div>
    </div>
    <p class="text-sm mb-3">
        {{-- content --}}
        {{ $post->content }}
    </p>
    <div class="other-post-buttons-container">
        {{-- buttons --}}
        <button><i class="fa-regular fa-face-laugh-squint"></i> <span
                class="text-sm">Haha</span></button>
        <button><i class="fa-regular fa-comment"></i> <span class="text-sm">Comment</span></button>
        <button><i class="fa-solid fa-share"></i> <span class="text-sm">Share</span></button>
    </div>
    {{-- comments-container --}}
    {{-- <div>
        <div class="ms-4 ">
            <div class="other-comment-content">
                <div class="xs-image-container"><img src="https://picsum.photos/32"
                        alt="other-user-comment"></div>
                <div class="flex-1">
                    <p class="other-comment-name"><b>Lorem Ipsum</b></p>
                    <p class="other-comment">Lorem ipsum dolor sit amet consectetur. In sed felis quis
                        mi sit sed pharetra mauris
                        lacus. Lectus morbi quis dolor tristique nisl in lorem. Vitae sed ut risus elit
                        urna
                        id praesent netus tellus. Velit in nec nisl proin.</p>
                    <p class="other-comment-time">5 minutes ago</p>
                </div>
            </div>
            <div class="other-post-buttons-container ms-8">
                <button><i class="fa-regular fa-face-laugh-squint"></i> <span
                        class="text-sm">Haha</span></button>
                <button><i class="fa-regular fa-comment"></i> <span
                        class="text-sm">Comment</span></button>
            </div>
        </div>
    </div> --}}
    <div class="post-comment-container">
        {{-- comment-container --}}
        <div class="comment-text-container">
            <div class="xs-image-container"><img src="https://picsum.photos/32" alt="user-comment">
            </div>
            <textarea name="" id="" placeholder="Here's my comment..."></textarea>
            <button><i class="fa-solid fa-arrow-right"></i></button>
        </div>
        <div></div>
    </div>
</div>
