<section class="hot-sale-wrapper">
    <div class="container">
        <div class="hot-sale-box">
            <!-- Header tiêu đề -->
            <div class="hot-sale-header text-center">
                <h2 class="title">
                    <i class="fas fa-fire-alt"></i> SẢN PHẨM <span>NỔI BẬT</span>
                </h2>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="product-slider-container swiper product-swiper"> <!-- Thêm class swiper -->
                <!-- Nút điều hướng (Để ngoài wrapper) -->
                <button class="slider-nav prev"><i class="fas fa-chevron-left"></i></button>

                <div class="product-grid swiper-wrapper"> <!-- Thêm class swiper-wrapper -->
                    @for ($i = 0; $i < 7; $i++)
                        {{-- Tăng số lượng để test slide --}}
                        <div class="product-item swiper-slide"> <!-- Thêm class swiper-slide -->
                            <div class="badge-container">
                                <span class="badge-sale">Giảm 30%</span>
                                <span class="badge-installment">Không trả góp</span>
                            </div>

                            <a href="#" class="product-img">
                                <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone-13-pro-max.png"
                                    alt="iPhone 13">
                            </a>

                            <div class="product-info">
                                <h3 class="product-name">
                                    <a href="#">iPhone 13 Pro Max 128GB - Cũ trầy xước</a>
                                </h3>
                                <div class="price-group">
                                    <span class="price-now">12.590.000đ</span>
                                    <span class="price-old">31.990.000đ</span>
                                </div>
                                <div class="product-footer">
                                    <span class="rating"><i class="fas fa-star"></i> 4.9</span>
                                    <button class="btn-favorite">
                                        <i class="far fa-heart"></i> Yêu thích
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <button class="slider-nav next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>
</section>

@push('styles')
    <style>
        /* Màu nền chủ đạo */
        .hot-sale-box {
            background: linear-gradient(180deg, #1E293C 0%, #be5466 100%);
            border-radius: 15px;
            padding: 20px 10px;
            position: relative;
            margin-top: 30px;
        }

        /* Tiêu đề Sản Phẩm Nổi Bật */
        .hot-sale-header .title {
            color: #fff;
            font-weight: 800;
            font-size: 28px;
            text-transform: uppercase;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .hot-sale-header .title span {
            color: #fff;
            /* Hiệu ứng viền chữ nếu muốn giống ảnh */
            text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.1);
        }

        .hot-sale-header .title i {
            color: #fff;
        }

        /* Container cho Grid */
        .product-slider-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .product-grid {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            scrollbar-width: none;
            /* Ẩn scrollbar Firefox */
            padding: 10px 5px;
        }

        .product-grid::-webkit-scrollbar {
            display: none;
        }

        /* Ẩn scrollbar Chrome */

        /* Thẻ sản phẩm trắng */
        .product-item {
            background: #fff;
            border-radius: 12px;
            min-width: 215px;
            flex: 0 0 auto;
            padding: 12px;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s;
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Nhãn Giảm giá & Trả góp */
        .badge-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .badge-sale {
            background: #d71921;
            color: #fff;
            font-size: 11px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .badge-installment {
            background: #eef5ff;
            color: #0065ff;
            font-size: 11px;
            border-radius: 4px;
            padding: 2px 6px;
            border: 1px solid #cce2ff;
        }

        /* Ảnh sản phẩm */
        .product-img {
            display: block;
            text-align: center;
            margin-bottom: 10px;
        }

        .product-img img {
            max-width: 100%;
            height: 160px;
            object-fit: contain;
        }

        /* Thông tin chữ */
        .product-name a {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            text-decoration: none;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 40px;
        }

        .price-group {
            margin: 10px 0;
        }

        .price-now {
            color: #d71921;
            font-weight: 800;
            font-size: 16px;
            display: block;
        }

        .price-old {
            color: #888;
            text-decoration: line-through;
            font-size: 12px;
        }

        /* Footer thẻ: Sao & Yêu thích */
        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .rating {
            font-size: 13px;
            font-weight: bold;
            color: #444;
        }

        .rating i {
            color: #ffbf00;
        }

        .btn-favorite {
            background: none;
            border: none;
            color: #2b80ff;
            font-size: 13px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Nút điều hướng Slider */
        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #fff;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            z-index: 5;
            cursor: pointer;
        }

        .slider-nav.prev {
            left: -17px;
        }

        .slider-nav.next {
            right: -17px;
        }

        /* Ghi đè lại các thuộc tính Flexbox cũ để Swiper quản lý */
        .product-grid.swiper-wrapper {
            display: flex;
            overflow: visible;
            /* Swiper cần overflow visible để slide hoạt động */
            gap: 0;
            /* Dùng spaceBetween trong JS thay vì gap */
        }

        .product-item.swiper-slide {
            min-width: unset;
            /* Bỏ min-width cũ để Swiper tự tính toán */
            height: auto;
            /* Để các card cao bằng nhau */
        }

        /* Ẩn nút điều hướng khi hết slide */
        .slider-nav.swiper-button-disabled {
            opacity: 0.3;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Đảm bảo container không bị tràn */
        .product-slider-container {
            overflow: hidden;
            padding: 10px 5px;
        }
    </style>
@endpush
