<section class="x-hero-section-wrapper">
    <div class="x-hero-container">
        <!-- Khối Banner Top: Slider + Banner Phụ -->
        <div class="x-hero-top-layout">
            <!-- Slider chính -->
            <div class="x-hero-main-carousel">
                <!-- Slider main container -->
                <div class="swiper x-hero-swiper-init">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <div class="swiper-slide">
                            <img src="{{ asset('images/banner_1.png') }}" alt="Banner 1">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('images/banner_2.png') }}" alt="Banner 2">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('images/banner_3.png') }}" alt="Banner 3">
                        </div>
                    </div>

                    <!-- Các nút điều hướng -->
                    <div class="swiper-pagination x-hero-dots"></div>
                    <div class="swiper-button-prev x-hero-prev"></div>
                    <div class="swiper-button-next x-hero-next"></div>
                </div>
            </div>

            <!-- Banner phải cố định -->
            <div class="x-hero-static-aside">
                <a href="#">
                    <img src="{{ asset('images/banner_right.png') }}" alt="Banner Right">
                </a>
            </div>
        </div>

        <!-- Khối Sản phẩm Hot phía dưới -->
        <div class="x-hero-hot-grid">
            <!-- Sản phẩm 1 -->
            <div class="x-hero-hot-card">
                <div class="x-hero-hot-tag">HOT</div>
                <div class="x-hero-card-inner">
                    <div class="x-hero-card-thumb">
                        <img src="{{ asset('images/s24_ultra.png') }}" alt="S24 Ultra">
                    </div>
                    <div class="x-hero-card-desc">
                        <h3>Galaxy <br> S24 Ultra</h3>
                        <p class="x-hero-card-price">930.000 won</p>
                    </div>
                </div>
            </div>

            <!-- Sản phẩm 2 -->
            <div class="x-hero-hot-card">
                <div class="x-hero-hot-tag">HOT</div>
                <div class="x-hero-card-inner">
                    <div class="x-hero-card-thumb">
                        <img src="{{ asset('images/iphone_17.png') }}" alt="Iphone 17">
                    </div>
                    <div class="x-hero-card-desc">
                        <h3>Galaxy <br> S24 Ultra</h3>
                        <p class="x-hero-card-price">930.000 won</p>
                    </div>
                </div>
            </div>

            <!-- Sản phẩm 3 -->
            <div class="x-hero-hot-card">
                <div class="x-hero-hot-tag">HOT</div>
                <div class="x-hero-card-inner">
                    <div class="x-hero-card-thumb">
                        <img src="{{ asset('images/z_fold_6.png') }}" alt="Z Fold 6">
                    </div>
                    <div class="x-hero-card-desc">
                        <h3>Galaxy <br> S24 Ultra</h3>
                        <p class="x-hero-card-price">930.000 won</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('styles')
    <style>
        /* =================================================== x-hero-section =============================================== */

        /* Container chung */
        .x-hero-container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .x-hero-section-wrapper {
            padding: 20px 0;
            background-color: #fff;
        }

        /* Layout Banner Top */
        .x-hero-top-layout {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .x-hero-main-carousel {
            flex: 3;
            /* Chiếm 75% */
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .x-hero-main-carousel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .x-hero-static-aside {
            flex: 1;
            /* Chiếm 25% */
        }

        .x-hero-static-aside img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Layout Hot Products Grid */
        .x-hero-hot-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .x-hero-hot-card {
            position: relative;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 20px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .x-hero-hot-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        /* Nhãn HOT màu đỏ chéo góc */
        .x-hero-hot-tag {
            position: absolute;
            top: 0;
            left: 0;
            background-color: #C10000;
            color: white;
            padding: 5px 25px;
            font-size: 12px;
            font-weight: bold;
            transform: rotate(-45deg) translate(-20px, -5px);
            z-index: 1;
        }

        /* Nội dung sản phẩm bên trong card */
        .x-hero-card-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .x-hero-card-thumb {
            flex: 1;
        }

        .x-hero-card-thumb img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }

        .x-hero-card-desc {
            flex: 1;
            text-align: right;
        }

        .x-hero-card-desc h3 {
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 10px 0;
            line-height: 1.2;
            color: #000;
        }

        .x-hero-card-price {
            font-size: 20px;
            color: #C10000;
            font-weight: bold;
            margin: 0;
        }
    </style>
@endpush
