<section class="featured-products">
    <div class="container">
        <!-- Header: Tiêu đề và Điều hướng -->
        <div class="d-flex justify-content-center align-items-end mb-4">
            <div class="section-title-wrapper">
                <h2 class="section-title">SẢN PHẨM NỔI BẬT</h2>
            </div>

            <!-- Điều hướng (Dành cho Slider sau này) -->

        </div>
        <div class="product-nav d-none d-md-flex mb-3 d-flex justify-content-end">
            <button class="nav-btn"><i class="fa-solid fa-chevron-left"></i></button>
            <div class="page-indicator"><span>1</span> / 2</div>
            <button class="nav-btn"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
        <!-- Danh sách sản phẩm -->
        <div class="row g-4">
            <!-- Bắt đầu lặp sản phẩm (Mẫu 1 Card) -->
            @for ($i = 1; $i <= 5; $i++)
                <div class="col-6 col-md-4 col-lg-2-4"> <!-- 5 cột trên desktop, 2 cột trên mobile -->
                    <div class="product-card">
                        <!-- Nhãn (Badge) -->
                        <div class="product-badge">New</div>

                        <!-- Hình ảnh -->
                        <div class="product-image">
                            <img src="{{ asset('images/13pro.png') }}" alt="iPhone 13 Pro">
                        </div>

                        <!-- Thông tin -->
                        <div class="product-content">
                            <h3 class="product-name">iPhone 13 Pro 256GB</h3>
                            <div class="product-price">759,000 <span class="currency">won</span></div>

                            <!-- Đánh giá -->
                            <div class="product-rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <span class="rating-count">(12)</span>
                            </div>

                            <!-- Nhóm nút bấm -->
                            <div class="product-actions">
                                <a href="https://m.me/yourpage" target="_blank" class="btn-messenger">
                                    <i class="fa-brands fa-facebook-messenger"></i> MUA NGAY
                                </a>
                                <a href="#" class="btn-detail">CHI TIẾT</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>

@push('styles')
    <style>
        /* ... (Các giữ nguyên các biến :root và style cũ của bạn) ... */
        :root {
            --messenger-color: #0084ff;
            --primary-red: #e01020;
            --text-dark: #1a1a1a;
            --bg-light: #f8f9fa;
        }

        .featured-products {
            padding: 60px 0;
            background-color: #fff;
        }

        /* Tiêu đề */
        .section-title-wrapper {
            position: relative;
        }

        .section-title {
            font-weight: 800;
            font-size: 26px;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .title-underline {
            width: 60px;
            height: 4px;
            background: var(--text-dark);
        }

        /* Card sản phẩm */
        .product-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 15px;
            position: relative;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            /* Đảm bảo hiệu ứng không tràn ra ngoài */
        }

        .product-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
            border-color: transparent;
        }

        /* Badge 'New' */
        .product-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #333;
            color: #fff;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: bold;
            border-radius: 4px;
            z-index: 5;
            /* Tăng z-index để nằm trên lớp mờ */
        }

        /* Ảnh sản phẩm và Hiệu ứng làm mờ 2 góc */
        .product-image {
            width: 100%;
            padding-top: 100%;
            position: relative;
            margin-bottom: 15px;
            overflow: hidden;
            /* Quan trọng để che lớp mờ khi chưa hover */
            border-radius: 8px;
        }

        /* Lớp mờ 1: Góc trái trên */
        .product-image::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 1px #ffffffda solid;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.024);
            /* Màu nền rất nhẹ */
            backdrop-filter: blur(0.5px);
            /* Tạo độ mờ */
            -webkit-backdrop-filter: blur(0.5px);
            z-index: 2;
            transform: translate(-100%, -100%);
            /* Giấu ở góc trái trên */
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Lớp mờ 2: Góc phải dưới */
        .product-image::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 1px #ffffffda solid;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(0.5px);
            -webkit-backdrop-filter: blur(0.5px);
            z-index: 2;
            transform: translate(100%, 100%);
            /* Giấu ở góc phải dưới */
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Khi hover vào card: Cả hai lớp cùng xuất hiện */
        .product-card:hover .product-image::before,
        .product-card:hover .product-image::after {
            transform: translate(0, 0);
        }

        .product-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.8s ease;
            z-index: 1;
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
            /* Tăng nhẹ độ phóng đại khi mờ sẽ đẹp hơn */
        }

        /* Các phần còn lại giữ nguyên */
        .product-content {
            position: relative;
            z-index: 3;
        }

        .product-name {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-dark);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 40px;
        }

        .product-price {
            color: var(--primary-red);
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .product-price .currency {
            font-size: 12px;
            text-transform: uppercase;
        }

        .product-rating {
            font-size: 11px;
            color: #ffc107;
            margin-bottom: 15px;
        }

        .rating-count {
            color: #888;
            margin-left: 5px;
        }

        .product-actions {
            display: flex;
            gap: 8px;
            margin-top: auto;
        }

        .btn-messenger {
            flex: 2;
            background: #1E293C;
            color: #fff;
            text-decoration: none;
            font-size: 11px;
            font-weight: 700;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border-radius: 6px;
            transition: 0.3s;
        }

        .btn-messenger:hover {
            background: var(--messenger-color);
            color: #fff;
        }

        .btn-detail {
            flex: 1;
            background: #f1f1f1;
            color: #555;
            text-decoration: none;
            font-size: 11px;
            font-weight: 700;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: 0.3s;
        }

        .btn-detail:hover {
            background: #ddd;
            color: #333;
        }

        .product-nav {
            align-items: center;
            gap: 15px;
        }

        .nav-btn {
            border: 1px solid #ddd;
            background: #fff;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            transition: 0.3s;
        }

        .nav-btn:hover {
            background: #000;
            color: #fff;
            border-color: #000;
        }

        @media (min-width: 992px) {
            .col-lg-2-4 {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }
    </style>
@endpush
