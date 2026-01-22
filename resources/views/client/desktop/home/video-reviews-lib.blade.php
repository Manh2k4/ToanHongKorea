<style>
    :root {
        --primary-color: #ff4757;
        --glass-bg: rgba(255, 255, 255, 0.1);
    }

    .vip-title {
        font-weight: 800;
        background: linear-gradient(45deg, #2d3436, #ff4757);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Video Card Style */
    .video-card-v2 {
        cursor: pointer;
        border-radius: 20px;
        overflow: hidden;
        background: #fff;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        position: relative;
    }

    .video-card-v2:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(255, 71, 87, 0.2);
    }

    .thumbnail-box {
        position: relative;
        aspect-ratio: 9/16;
        /* Tỉ lệ video dọc chuẩn TikTok */
        overflow: hidden;
    }

    .main-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .video-card-v2:hover .main-thumb {
        transform: scale(1.1);
    }

    .overlay-gradient {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 60%, rgba(0, 0, 0, 0.8));
    }

    .play-icon-v2 {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.8);
        width: 60px;
        height: 60px;
        background: rgba(255, 71, 87, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        opacity: 0;
        transition: 0.3s;
        box-shadow: 0 0 20px rgba(255, 71, 87, 0.5);
    }

    .video-card-v2:hover .play-icon-v2 {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }

    .product-count-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(5px);
        color: #white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        color: white;
        z-index: 2;
    }

    .video-info-v2 {
        padding: 15px;
        background: white;
    }

    .video-title-v2 {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        color: #2d3436;
    }

    /* Modal Styling */
    .video-modal-content {
        border-radius: 25px;
        overflow: hidden;
        border: none;
    }

    .video-container-v2 {
        min-height: 70vh;
        max-height: 90vh;
    }

    #clientVideoPlayer {
        width: 100%;
        max-height: 90vh;
        outline: none;
    }

    .product-sidebar {
        max-height: 90vh;
        overflow-y: auto;
    }

    .btn-close-vip {
        position: absolute;
        right: 20px;
        top: 20px;
        z-index: 99;
        background: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        transition: 0.3s;
    }

    .btn-close-vip:hover {
        transform: rotate(90deg);
        color: var(--primary-color);
    }

    /* List product in modal */
    .product-item-mini {
        display: flex;
        align-items: center;
        padding: 12px;
        background: white;
        border-radius: 15px;
        margin-bottom: 12px;
        transition: 0.3s;
        border: 1px solid #eee;
        text-decoration: none;
        color: inherit;
    }

    .product-item-mini:hover {
        transform: translateX(5px);
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .product-item-mini img {
        width: 70px;
        height: 70px;
        object-fit: contain;
        border-radius: 10px;
        margin-right: 15px;
    }

    .product-mini-info h5 {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .product-mini-info .price {
        color: var(--primary-color);
        font-weight: 800;
    }

    /* Navigation */
    .swiper-navigation-custom {
        display: flex;
        gap: 10px;
    }

    .swiper-button-prev-custom,
    .swiper-button-next-custom {
        width: 40px;
        height: 40px;
        border: 1px solid #ddd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s;
    }

    .swiper-button-prev-custom:hover,
    .swiper-button-next-custom:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .product-img-wrapper {
        width: 70px;
        height: 70px;
        flex-shrink: 0;
        margin-right: 15px;
        background: #f8f9fa;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        /* Giúp ảnh điện thoại không bị móp méo */
    }

    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .video-container-v2 {
            min-height: 50vh;
        }

        .product-sidebar {
            max-height: 40vh;
        }
    }

    .videoSwiper {
        padding: 10px 5px 30px 5px;
        /* Thêm padding 2 bên để không bị cắt mất bóng đổ (shadow) khi hover */
        overflow: hidden !important;
        /* Đổi từ visible sang hidden để cắt phần thừa ngoài 1200px */
    }

    /* Tạo chương trình Swiper */

    .swiper {
        width: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    /* Chương trình Swiper cơ bản */
    .swiper-slide {
        height: auto;
        /* Đảm bảo các slide có chiều cao bằng nhau */
        user-select: none;
        /* Ngăn chặn việc bôi đen chữ khi đang kéo */
    }

    /* Tối ưu cho di động để vuốt nhanh không bị khựng */
    .swiper-wrapper {
        transition-timing-function: cubic-bezier(0.25, 1, 0.5, 1);
    }

    /* Ẩn nút điều hướng trên điện thoại vì người dùng hay vuốt tay hơn */
    @media (max-width: 768px) {
        .swiper-navigation-custom {
            display: none;
        }

        .vip-title {
            font-size: 1.5rem;
        }
    }
</style>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Khởi tạo Swiper
        const swiper = new Swiper('.videoSwiper', {
            slidesPerView: 1.5, // Hiển thị 1 cái rưỡi để người dùng biết là còn phía sau
            spaceBetween: 15,
            grabCursor: true, // Hiện bàn tay khi di chuột vào
            freeMode: true, // Lướt tự do, không bắt buộc dừng đúng khựng ở từng slide
            mousewheel: {
                forceToAxis: true, // Cho phép cuộn bằng chuột
            },
            navigation: {
                nextEl: '.swiper-button-next-custom',
                prevEl: '.swiper-button-prev-custom',
            },
            breakpoints: {
                // Điện thoại nhỏ
                320: {
                    slidesPerView: 1.8,
                    spaceBetween: 10
                },
                // Điện thoại vừa
                480: {
                    slidesPerView: 2.2,
                    spaceBetween: 15
                },
                // Máy tính bảng
                768: {
                    slidesPerView: 3.2,
                    spaceBetween: 20,
                    freeMode: false // Tablet/Desktop thì nên để dừng đúng slide
                },
                // Laptop
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 25,
                    freeMode: false
                },
                // Màn hình lớn
                1400: {
                    slidesPerView: 5,
                    spaceBetween: 25,
                    freeMode: false
                }
            }
        });

        function openVideoModal(videoUrl, title, products) {
            const player = document.getElementById('clientVideoPlayer');
            const productList = document.getElementById('modalProductList');

            // 1. Set Video
            player.src = videoUrl;
            player.play();

            // 2. Render Products
            productList.innerHTML = ''; // Clear cũ

            if (products && products.length > 0) {
                products.forEach(product => {
                    // Bước 1: Tạo route mẫu từ Laravel Blade, dùng chữ ':slug' làm placeholder
                    let detailUrl = "{{ route('phone.detail', ':slug') }}";

                    // Bước 2: Dùng JS replace chữ ':slug' bằng slug thật của sản phẩm
                    detailUrl = detailUrl.replace(':slug', product.slug);
                    // Giả định product có name, main_image_url, và min_price từ variant
                    const price = product.variants && product.variants.length > 0 ?
                        new Intl.NumberFormat('ko-KR', { // Sử dụng locale Hàn Quốc để định dạng chuẩn
                            style: 'currency',
                            currency: 'KRW',
                            // Nếu bạn muốn hiển thị số nguyên (vì tiền Won ít khi dùng số lẻ)
                            minimumFractionDigits: 0
                        }).format(product.variants[0].price) :
                        'Liên hệ';

                    productList.innerHTML += `
                    <a href="${detailUrl}" class="product-item-mini">
                        <img src="/storage/${product.main_image}" alt="${product.name}">
                        <div class="product-mini-info">
                            <h5>${product.name}</h5>
                            <div class="price">${price}</div>
                        </div>
                        <i class="fas fa-chevron-right ms-auto text-muted"></i>
                    </a>
                `;
                });
            } else {
                productList.innerHTML = '<p class="text-muted">Không có sản phẩm đính kèm.</p>';
            }

            // 3. Show Modal
            $('#clientVideoModal').modal('show');
        }

        // Tự động dừng video khi đóng modal
        $(document).ready(function() {
            $('#clientVideoModal').on('hidden.bs.modal', function() {
                const player = document.getElementById('clientVideoPlayer');
                player.pause();
                player.src = "";
            });

            // Đóng bằng nút X tự tạo
            $('.btn-close-vip').on('click', function() {
                $('#clientVideoModal').modal('hide');
            });
        });
    </script>
@endpush
