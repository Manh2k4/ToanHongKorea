<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<section class="mobile-video-section py-4">
    <div class="px-3 mb-3 d-flex align-items-center justify-content-between">
        <h2 class="m-0" style="font-weight: 800; font-size: 1.25rem; color: #1a1a1a;">Góc Review</h2>
        <span class="text-muted" style="font-size: 0.8rem;">Vuốt để xem <i class="fas fa-chevron-right ms-1"></i></span>
    </div>

    <!-- Swiper Videos -->
    <div class="swiper mobileVideoSwiper ps-3">
        <div class="swiper-wrapper">
            @foreach ($videos as $video)
                <div class="swiper-slide">
                    <div class="m-video-card"
                        onclick="openMobileVideo('{{ $video->video_url }}', {{ $video->phones->toJson() }})">
                        <img src="{{ $video->thumbnail_url }}" class="m-video-thumb">
                        <div class="m-product-badge">
                            <i class="fas fa-shopping-bag"></i> {{ $video->phones->count() }} sản phẩm
                        </div>
                        <div class="m-video-overlay">
                            <div class="m-video-title">{{ $video->title }}</div>
                        </div>
                        <div class="m-play-btn"><i class="fas fa-play"></i></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- FULLSCREEN VIDEO PLAYER (Dành riêng cho Mobile) -->
<div id="mobileVideoOverlay" class="mobile-video-overlay">
    <button class="close-overlay-btn" onclick="closeMobileVideo()">
        <i class="fas fa-times"></i>
    </button>

    <video id="mobilePlayer" playsinline loop>
        <source src="" type="video/mp4">
    </video>

    <!-- Bottom Sheet Products -->
    <div id="bottomSheet" class="product-bottom-sheet">
        <div class="sheet-handle-wrapper" onclick="toggleBottomSheet()">
            <div class="sheet-handle"></div>
        </div>

        <div class="sheet-content">
            <h5 class="sheet-title">Sản phẩm trong video</h5>
            <div id="mobileProductList" class="mobile-product-list">
                <!-- JS render sản phẩm vào đây -->
            </div>
        </div>
    </div>

    <!-- Nút mở giỏ hàng nhanh (Nếu đang đóng sheet) -->
    <button class="floating-cart-btn" onclick="toggleBottomSheet()">
        <i class="fas fa-shopping-bag"></i>
        <span id="m-product-count">0</span>
    </button>
</div>
@include('client.mobile.home.video-reviews-lib')
