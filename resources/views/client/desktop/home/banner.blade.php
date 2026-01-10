<section class="hs-wrapper">
    <div class="hs-container">
        <!-- Khối 1: Banner chính & Aside -->
        <div class="hs-top-grid">
            <!-- Slider chính -->
            <div class="hs-main-slider">
                <div class="swiper hs-swiper-init">
                    <div class="swiper-wrapper">
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
                    <!-- Navigation tinh tế hơn -->
                    <div class="swiper-pagination hs-dots"></div>
                    <div class="swiper-button-prev hs-nav-btn"></div>
                    <div class="swiper-button-next hs-nav-btn"></div>
                </div>
            </div>

            <!-- Banner phải (Aside Promo) -->
            <div class="hs-aside-promo">
                <a href="{{ url('phone/iphone-17-pro-max') }}" class="hs-aside-link">
                    <img src="{{ asset('images/banner_right.png') }}" alt="Banner Right">
                    <div class="hs-aside-overlay">
                        <span>Khám phá ngay <i class="fa-solid fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Khối 2: Hot Deals Grid (Sản phẩm nổi bật) -->
        <div class="hs-hot-deals">
            <!-- Item 1: Samsung -->
            <a href="{{ url('/phone/samsung-galaxy-s24-ultra') }}" class="hs-deal-card">
                <div class="hs-badge">HOT DEAL</div>
                <div class="hs-card-content">
                    <div class="hs-image">
                        <img src="{{ asset('images/s24_ultra.png') }}" alt="S24 Ultra">
                    </div>
                    <div class="hs-info">
                        <p class="hs-brand">Samsung Galaxy</p>
                        <h3 class="hs-name">S24 Ultra</h3>
                        <p class="hs-price">930.000 <span>won</span></p>
                    </div>
                </div>
            </a>

            <!-- Item 2: iPhone -->
            <a href="{{ url('/phone/iphone-17-pro-max') }}" class="hs-deal-card hs-featured">
                <div class="hs-badge">PRE-ORDER</div>
                <div class="hs-card-content">
                    <div class="hs-image">
                        <img src="{{ asset('images/iphone_17.png') }}" alt="Iphone 17">
                    </div>
                    <div class="hs-info">
                        <p class="hs-brand">Apple iPhone</p>
                        <h3 class="hs-name">17 Pro Max</h3>
                        <p class="hs-price">1.250.000 <span>won</span></p>
                    </div>
                </div>
            </a>

            <!-- Item 3: Z Flip -->
            <a href="{{ url('/phone/samsung-galaxy-z-flip-7') }}" class="hs-deal-card">
                <div class="hs-badge">NEW TREND</div>
                <div class="hs-card-content">
                    <div class="hs-image">
                        <img src="{{ asset('images/galaxyflip7.png') }}" alt="Z Flip 7">
                    </div>
                    <div class="hs-info">
                        <p class="hs-brand">Samsung Galaxy</p>
                        <h3 class="hs-name">Z Flip 7</h3>
                        <p class="hs-price">890.000 <span>won</span></p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
