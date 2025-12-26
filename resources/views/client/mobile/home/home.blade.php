
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- Font Awesome bản mới nhất -->

<link rel="stylesheet" href="{{ asset('css/client_styles_mb.css') }}">
<script src="{{ asset('js/main_mb.js') }}"></script>
<header class="mobile-header">
    <!-- 1. Thanh tìm kiếm trên cùng (Gray bar) -->
    <div class="top-search-bar">
        <div class="search-container">
            <input type="text" placeholder="Tìm kiếm...">
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>

    <!-- 2. Thanh điều hướng chính (Navy bar) -->
    <div class="main-nav-bar">
        <div class="menu-toggle" id="openMenu">
            <i class="fa-solid fa-bars"></i>
        </div>

        <div class="mobile-logo">
            <a href="/">
                <img src="{{ asset('logo/logo_remove.png') }}" alt="Toanhong Korea">
            </a>
        </div>

        <div class="mobile-actions">
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

    <!-- 3. Overlay & Drawer Menu -->
    <div class="menu-overlay" id="menuOverlay"></div>

    <div class="side-drawer" id="sideDrawer">
        <!-- Header của Menu -->
        <div class="drawer-header">
            <div class="header-left">
                <i class="fa-solid fa-bars"></i>
                <span class="menu-title">MENU</span>
            </div>
            <div class="close-btn" id="closeMenu">
                <i class="fa-solid fa-xmark"></i>
            </div>
        </div>

        <!-- Các nút chức năng nhanh (Grid 2x2) -->
        <div class="quick-links">
            <a href="/" class="q-link">Trang chủ</a>
            <a href="/lien-he" class="q-link">Liên hệ</a>
        </div>

        <!-- Danh mục chính -->
        <div class="category-section">
            <div class="category-header">DANH MỤC CHÍNH</div>

            <ul class="mobile-accordion-menu">
                <!-- Menu iPhone -->
                <li class="has-dropdown">
                    <div class="nav-link-wrapper">
                        <a href="/iphone" class="main-link">
                            <span>Iphone</span>
                        </a>
                        <span class="arrow-toggle"><i class="fa-solid fa-chevron-right"></i></span>
                    </div>

                    <ul class="dropdown-menu">
                        <li class="has-submenu">
                            <div class="nav-link-wrapper">
                                <a href="/iphone-11-series">iPhone 11 Series</a>
                                <span class="arrow-toggle"><i class="fa-solid fa-chevron-right"></i></span>
                            </div>
                            <ul class="submenu">
                                <li><a href="/iphone-11">iPhone 11</a></li>
                                <li><a href="/iphone-11-pro">iPhone 11 Pro</a></li>
                                <li><a href="/iphone-11-pro-max">iPhone 11 Pro Max</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <div class="nav-link-wrapper">
                                <a href="/iphone-15-series">iPhone 15 Series</a>
                                <span class="arrow-toggle"><i class="fa-solid fa-chevron-right"></i></span>
                            </div>
                            <ul class="submenu">
                                <li><a href="/iphone-15-pro">iPhone 15 Pro</a></li>
                                <li><a href="/iphone-15-pro-max">iPhone 15 Pro Max</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Menu Samsung -->
                <li class="has-dropdown">
                    <div class="nav-link-wrapper">
                        <a href="/samsung" class="main-link">
                            <span>Samsung</span>
                        </a>
                        <span class="arrow-toggle"><i class="fa-solid fa-chevron-right"></i></span>
                    </div>
                    <ul class="dropdown-menu">
                        <li class="has-submenu">
                            <div class="nav-link-wrapper">
                                <a href="/galaxy-s">Galaxy S Series</a>
                                <span class="arrow-toggle"><i class="fa-solid fa-chevron-right"></i></span>
                            </div>
                            <ul class="submenu">
                                <li><a href="/s24-ultra">Galaxy S24 Ultra</a></li>
                                <li><a href="/s21">Galaxy S21</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Menu Dịch vụ Sim -->
                <li class="has-dropdown">
                    <div class="nav-link-wrapper">
                        <a href="/dich-vu-sim" class="main-link">Dịch vụ Sim</a>
                        <span class="arrow-toggle"><i class="fa-solid fa-chevron-right"></i></span>
                    </div>
                    <ul class="dropdown-menu">
                        <li class="has-submenu">
                            <div class="nav-link-wrapper">
                                <a href="/sim-hop-phap">Sim Hợp Pháp</a>
                                <span class="arrow-toggle"><i class="fa-solid fa-chevron-right"></i></span>
                            </div>
                            <ul class="submenu">
                                <li><a href="/sim-tra-truoc">Sim trả trước</a></li>
                                <li><a href="/sim-tra-sau">Sim trả sau</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <div class="nav-link-wrapper">
                                <a href="/sim-bhp">Sim BHP</a>
                                <span class="arrow-toggle"><i class="fa-solid fa-chevron-right"></i></span>
                            </div>
                            <ul class="submenu">
                                <li><a href="/sim-bhp-tra-truoc">Sim trả trước</a></li>
                                <li><a href="/sim-bhp-tra-sau">Sim trả sau</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>
