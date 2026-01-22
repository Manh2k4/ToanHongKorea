<!-- Thêm Swiper CSS để slide mượt -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<section class="video-review-section py-5" style="overflow: hidden;"> <!-- Thêm overflow hidden ở đây để chắc chắn -->
    <div class="container" style="max-width: 1200px !important; padding: 0 15px;">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="vip-title mb-1">Góc Review Siêu Phẩm</h2>
                <span class="text-muted">Trải nghiệm thực tế</span>
            </div>
            <div class="swiper-navigation-custom">
                <div class="swiper-button-prev-custom"><i class="fas fa-chevron-left"></i></div>
                <div class="swiper-button-next-custom"><i class="fas fa-chevron-right"></i></div>
            </div>
        </div>

        <div class="swiper videoSwiper">
            <div class="swiper-wrapper">
                @foreach ($videos as $video)
                    <div class="swiper-slide">
                        <div class="video-card-v2"
                            onclick="openVideoModal('{{ $video->video_url }}', '{{ $video->title }}', {{ $video->phones->toJson() }})">
                            <div class="thumbnail-box">
                                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="main-thumb">
                                <div class="overlay-gradient"></div>
                                <div class="play-icon-v2">
                                    <i class="fas fa-play"></i>
                                </div>
                                <!-- Badge số lượng sản phẩm -->
                                <div class="product-count-badge">
                                    <i class="fas fa-shopping-bag"></i> {{ $video->phones->count() }} Sản phẩm
                                </div>
                            </div>
                            <div class="video-info-v2">
                                <h3 class="video-title-v2 text-truncate">{{ $video->title }}</h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- MODAL VIPPRO -->
<div class="modal fade" id="clientVideoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content video-modal-content">
            <button type="button" class="btn-close-vip" data-bs-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <!-- Cột Video -->
                    <div
                        class="col-lg-7 col-md-6 bg-black d-flex align-items-center justify-content-center video-container-v2">
                        <video id="clientVideoPlayer" controls playsinline>
                            <source src="" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <!-- Cột Sản phẩm đi kèm -->
                    <div class="col-lg-5 col-md-6 bg-light product-sidebar">
                        <div class="p-4">
                            <h4 class="sidebar-title mb-4">Sản phẩm trong video</h4>
                            <div id="modalProductList" class="product-list-v2">
                                <!-- Sản phẩm sẽ được render bằng JS -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('client.desktop.home.video-reviews-lib')
