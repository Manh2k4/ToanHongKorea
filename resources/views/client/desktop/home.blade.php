<link rel="stylesheet" href="{{ asset('css/client_styles.css') }}">
<script src="{{ asset('js/main.js') }}"></script>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- Font Awesome để dùng icon search, user, heart, arrow -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<link rel="stylesheet" href="{{ asset('css/client_styles.css') }}">
<script src="{{ asset('js/main.js') }}"></script>
<header class="main-header">
    <div class="container">
        <!-- Top Header: Logo, Search, Actions -->
        <div class="header-top">
            <div class="logo">
                <a href="/">
                    <img src="{{ asset('logo/logo_remove.png') }}" alt="Toanhong Korea">
                </a>
            </div>

            <div class="search-box">
                <form action="/search" method="GET">
                    <input type="text" name="q" placeholder="Tìm kiếm...">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>

            <div class="header-user-actions">
                @auth
                    <!-- Hiển thị khi ĐÃ đăng nhập -->
                    <a href="/account" class="action-item">
                        <i class="fa-regular fa-circle-user"></i>
                        <span>{{ auth()->user()->name }}</span>
                    </a>

                    <a href="/wishlist" class="action-item">
                        <i class="fa-regular fa-heart"></i>
                        <span>Yêu thích</span>
                    </a>

                    <!-- Nút Đăng xuất (Laravel yêu cầu dùng POST để an toàn) -->
                    <a href="{{ route('logout') }}" class="action-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Đăng xuất</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endauth

                @guest
                    <!-- Hiển thị khi CHƯA đăng nhập -->
                    <a href="{{ route('login') }}" class="action-item">
                        <i class="fa-regular fa-circle-user"></i>
                        <span>Đăng nhập</span>
                    </a>

                    <a href="/wishlist" class="action-item">
                        <i class="fa-regular fa-heart"></i>
                        <span>Yêu thích</span>
                    </a>
                @endguest
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="main-navigation">
            <ul class="nav-list">
                <li><a href="/">Trang Chủ</a></li>

                <!-- Menu iPhone với Dropdown đa cấp -->
                <li class="has-dropdown">
                    <a href="/iphone">
                        <img src="{{ asset('logo/logo_apple.png') }}" alt="Apple" class="nav-icon_apple">
                        Iphone <i class="fa-solid fa-chevron-right arrow-icon"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="has-submenu">
                            <a href="/iphone-11-series">iPhone 11 Series <i class="fa-solid fa-chevron-right"></i></a>
                            <ul class="submenu">
                                <li><a href="/iphone-11">iPhone 11</a></li>
                                <li><a href="/iphone-11-pro">iPhone 11 Pro</a></li>
                                <li><a href="/iphone-11-pro-max">iPhone 11 Pro Max</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="/iphone-15-series">iPhone 15 Series <i class="fa-solid fa-chevron-right"></i></a>
                            <ul class="submenu">
                                <li><a href="/iphone-15-pro">iPhone 15 Pro</a></li>
                                <li><a href="/iphone-15-pro-max">iPhone 15 Pro Max</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Menu Samsung -->

                <li class="has-dropdown">
                    <a href="/samsung">
                        <img src="{{ asset('logo/logo_samsung.png') }}" alt="Samsung" class="nav-icon_samsung"> <i
                            class="fa-solid fa-chevron-right arrow-icon" style="margin-top: 6px"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="has-submenu">
                            <a href="/galaxy-s">Galaxy S Series <i class="fa-solid fa-chevron-right"></i></a>
                            <ul class="submenu">
                                <li><a href="/iphone-11">Galaxy S24 Ultra</a></li>
                                <li><a href="/iphone-11-pro">Galaxy S21</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Menu Dịch vụ Sim với Dropdown đa cấp -->
                <li class="has-dropdown">
                    <a href="/iphone">
                        Dịch vụ Sim <i class="fa-solid fa-chevron-right arrow-icon"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="has-submenu">
                            <a href="/iphone-11-series">Sim Hợp Pháp <i class="fa-solid fa-chevron-right"></i></a>
                            <ul class="submenu">
                                <li><a href="/iphone-11">Sim trả trước</a></li>
                                <li><a href="/iphone-11-pro">Sim trả sau</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="/iphone-15-series">Sim BHP <i class="fa-solid fa-chevron-right"></i></a>
                            <ul class="submenu">
                                <li><a href="/iphone-11">Sim trả trước</a></li>
                                <li><a href="/iphone-11-pro">Sim trả sau</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>



                <li><a href="/lien-he">Liên Hệ</a></li>
            </ul>
        </nav>
    </div>
</header>


<section class="banner-section">
    <div class="container">
        <!-- Khối Banner Top: Slider + Banner Phụ -->
        <div class="banner-top-layout">
            <!-- Slider chính -->
            <div class="main-slider">
                <!-- Slider main container -->
                <div class="swiper banner-swiper">
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

                    <!-- Các nút điều hướng (Tùy chọn) -->
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>

            <!-- Banner phải cố định (Giữ nguyên từ code trước) -->
            <div class="side-banner">
                <a href="#">
                    <img src="{{ asset('images/banner_right.png') }}" alt="Banner Right">
                </a>
            </div>
        </div>

        <!-- Khối Sản phẩm Hot phía dưới -->
        <div class="hot-products-grid">
            <!-- Sản phẩm 1 -->
            <div class="product-hot-card">
                <div class="hot-label">HOT</div>
                <div class="product-content">
                    <div class="product-img">
                        <img src="{{ asset('images/s24_ultra.png') }}" alt="S24 Ultra">
                    </div>
                    <div class="product-info">
                        <h3>Galaxy <br> S24 Ultra</h3>
                        <p class="price">930.000 won</p>
                    </div>
                </div>
            </div>

            <!-- Sản phẩm 2 -->
            <div class="product-hot-card">
                <div class="hot-label">HOT</div>
                <div class="product-content">
                    <div class="product-img">
                        <img src="{{ asset('images/iphone_17.png') }}" alt="Iphone 17">
                    </div>
                    <div class="product-info">
                        <h3>Galaxy <br> S24 Ultra</h3>
                        <p class="price">930.000 won</p>
                    </div>
                </div>
            </div>

            <!-- Sản phẩm 3 -->
            <div class="product-hot-card">
                <div class="hot-label">HOT</div>
                <div class="product-content">
                    <div class="product-img">
                        <img src="{{ asset('images/z_fold_6.png') }}" alt="Z Fold 6">
                    </div>
                    <div class="product-info">
                        <h3>Galaxy <br> S24 Ultra</h3>
                        <p class="price">930.000 won</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
