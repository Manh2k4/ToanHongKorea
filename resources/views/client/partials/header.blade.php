<header class="main-header">
    <div class="container top-header">
        <div class="header-contact-info">
            <div class="contact-item">
                <i class="fas fa-phone-alt"></i>
                <span>HOTLINE</span>
                <strong>0974 933 486</strong>
            </div>
            <div class="contact-item">
                <i class="fas fa-shipping-fast"></i>
                <span>GIAO HÀNG TOÀN QUỐC</span>
            </div>
            <div class="contact-item">
                <i class="fas fa-wallet"></i>
                <span>THANH TOÁN TẠI NHÀ</span>
            </div>
        </div>

        <div class="header-search-bar">

            <input type="text" placeholder="Bạn tìm kiếm sản phẩm nào?">
            <button class="search-button">Tìm kiếm</button>
        </div>
    </div>

    <div class="container main-nav">
        <div class="logo">
            <a href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" alt="HB Group Logo"></a>

            <!-- Bạn cần thay thế src bằng đường dẫn ảnh logo thực tế của HB Group -->
        </div>

        <nav class="nav-links">
            <a href="{{ route('home') }}" class="nav-item"><i class="fas fa-fire nav-icon"></i> KHUYẾN MẠI</a>
            <a href="{{ route('pages.about') }}" class="nav-item">GIỚI THIỆU</a>
            <a href="{{ route('pages.gallery') }}" class="nav-item">TRƯNG BÀY</a>
            <a href="{{ route('pages.contact') }}" class="nav-item">LIÊN HỆ</a>
        </nav>

        <div class="auth-section">
            @auth
                <div class="user-info-dropdown" id="userDropdown">
                    <a href="#" class="user-avatar" id="dropdownAvatar">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="avatar-img">
                        @else
                            <div class="initial-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-content">
                        {{-- <a href="{{ route('profile.edit') }}">Thông tin tài khoản</a> --}}
                        <a href="{{ route('client.order.index') }}">Lịch sử đơn hàng</a>

                        @if (Auth::user()->role_id == 1)
                            <a href="{{ route('dashboard') }}">Trang quản trị</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" style="display: none;" id="logout-form">
                            @csrf
                        </form>
                        <a href="#" id="logoutButton">Đăng xuất</a>
                    </div>
                </div>
            @endauth

            @guest
                <a href="{{ route('register') }}" class="auth-button register-btn">Đăng ký</a>
                <a href="{{ route('login') }}" class="auth-button login-btn">Đăng nhập</a>
            @endguest
        </div>
    </div>

    <div class="bottom-header">
        <div class="container">
            <div class="category-menu-wrapper">
                <button class="category-menu-toggle">
                    <i class="fas fa-bars"></i> DANH MỤC SẢN PHẨM
                </button>
                <ul class="category-dropdown-menu">
                    @foreach ($categories as $category)
                        <li><a
                                href="{{ route('client.category.show_products_by_category', $category->id) }}">{{ $category->name }}</a>
                        </li>
                        {{-- Hoặc nếu dùng slug: --}}
                        {{-- <li><a href="{{ route('client.category.show_products_by_category', $category->slug) }}">{{ $category->name }}</a></li> --}}
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</header>

<style>
    .avatar-img {
        width: 40px;
        /* Hoặc kích thước mong muốn */
        height: 40px;
        /* Hoặc kích thước mong muốn */
        border-radius: 50%;
        /* Để làm tròn ảnh */
        object-fit: cover;
        /* Đảm bảo ảnh không bị méo */
        margin-right: 10px;
        /* Khoảng cách với tên */
        vertical-align: middle;
    }

    /* Kiểu cho avatar chữ cái */
    .initial-avatar {
        width: 40px;
        /* Cùng kích thước với avatar ảnh */
        height: 40px;
        /* Cùng kích thước với avatar ảnh */
        border-radius: 50%;
        /* Để làm tròn */
        background-color: #007bff;
        /* Màu nền (chọn màu bạn thích) */
        color: white;
        /* Màu chữ */
        display: flex;
        /* Dùng flexbox để căn giữa chữ */
        justify-content: center;
        /* Căn giữa ngang */
        align-items: center;
        /* Căn giữa dọc */
        font-size: 18px;
        /* Kích thước chữ */
        font-weight: bold;
        /* Chữ đậm */
        margin-right: 10px;
        /* Khoảng cách với tên */
        vertical-align: middle;
    }

    /* Đảm bảo phần tử cha .user-avatar hiển thị các thành phần cạnh nhau */
    .user-avatar {
        display: flex;
        align-items: center;
        text-decoration: none;
        /* Bỏ gạch chân cho link */
        color: inherit;
        /* Kế thừa màu chữ */
    }

    .user-avatar span {
        margin-left: 5px;
        /* Khoảng cách giữa avatar và tên */
    }

    /* Các kiểu khác nếu cần thiết cho dropdown */
    .user-info-dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        border-radius: 5px;
        right: 0;
        /* Đặt dropdown bên phải */
        top: 100%;
        /* Ngay bên dưới avatar */
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .user-info-dropdown:hover .dropdown-content {
        display: block;
    }

    /* Basic styling for the user dropdown */
    .auth-section {
        position: relative;
        display: flex;
        align-items: center;
    }

    .user-info-dropdown {
        position: relative;
        /* Giữ nguyên */
    }

    .user-avatar {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #333;
        font-weight: bold;
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 5px;
        transition: background-color 0.2s ease;
    }

    .user-avatar:hover {
        background-color: #f0f0f0;
    }

    .user-avatar .avatar-img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 8px;
        object-fit: cover;
        border: 1px solid #ddd;
        flex-shrink: 0;
    }

    .user-info-dropdown .dropdown-content {
        display: none;
        /* Mặc định ẩn, JS sẽ bật lên */
        position: absolute;
        background-color: #f9f9f9;
        min-width: 180px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 100;
        right: 0;
        top: calc(100% + 5px);
        /* Khoảng cách giữa avatar và dropdown */
        border-radius: 4px;
        overflow: hidden;
        opacity: 0;
        /* Thêm hiệu ứng fade */
        visibility: hidden;
        /* Thêm hiệu ứng fade */
        transform: translateY(-10px);
        /* Thêm hiệu ứng trượt */
        transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
    }

    .user-info-dropdown .dropdown-content.show {
        /* Class 'show' sẽ được thêm bằng JS */
        display: block;
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .user-info-dropdown .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
        transition: background-color 0.2s ease;
    }

    .user-info-dropdown .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    /* Style for auth buttons when not logged in */
    .auth-button {
        background-color: #f8d022;
        color: #333;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        margin-left: 10px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .auth-button:hover {
        background-color: #e6b800;
    }
</style>

{{-- Thêm script vào cuối body --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userDropdown = document.getElementById('userDropdown');
        const dropdownAvatar = document.getElementById('dropdownAvatar');
        const dropdownContent = userDropdown ? userDropdown.querySelector('.dropdown-content') : null;
        const logoutButton = document.getElementById('logoutButton');
        const logoutForm = document.getElementById('logout-form');

        if (userDropdown && dropdownAvatar && dropdownContent) {
            let timeout;

            // Hàm hiển thị dropdown
            const showDropdown = () => {
                clearTimeout(timeout);
                dropdownContent.classList.add('show');
            };

            // Hàm ẩn dropdown
            const hideDropdown = () => {
                timeout = setTimeout(() => {
                    dropdownContent.classList.remove('show');
                }, 100); // Thêm một độ trễ nhỏ để tránh ẩn ngay lập tức
            };

            // Xử lý hover vào toàn bộ vùng dropdown
            userDropdown.addEventListener('mouseenter', showDropdown);
            userDropdown.addEventListener('mouseleave', hideDropdown);

            // Xử lý click Đăng xuất
            if (logoutButton && logoutForm) {
                logoutButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    logoutForm.submit();
                });
            }

            // Đóng dropdown khi click ra ngoài (tùy chọn)
            document.addEventListener('click', function(event) {
                if (!userDropdown.contains(event.target) && dropdownContent.classList.contains(
                        'show')) {
                    dropdownContent.classList.remove('show');
                }
            });
        }
    });
</script>
