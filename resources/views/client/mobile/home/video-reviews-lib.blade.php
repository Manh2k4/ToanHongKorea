<style>
    /* Section Home */
    .m-video-card {
        position: relative;
        aspect-ratio: 9/16;
        border-radius: 15px;
        overflow: hidden;
        background: #000;
    }

    .m-video-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .m-video-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 10px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
    }

    .m-video-title {
        color: white;
        font-size: 0.85rem;
        font-weight: 600;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .m-product-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 71, 87, 0.9);
        color: white;
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 10px;
    }

    .m-play-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: rgba(255, 255, 255, 0.8);
        font-size: 2rem;
    }

    /* Fullscreen Overlay */
    .mobile-video-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #000;
        z-index: 9999;
        display: none;
        flex-direction: column;
    }

    #mobilePlayer {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .close-overlay-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(0, 0, 0, 0.5);
        border: none;
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        z-index: 10001;
    }

    /* Bottom Sheet */
    .product-bottom-sheet {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background: white;
        border-radius: 20px 20px 0 0;
        transition: transform 0.4s cubic-bezier(0.1, 0.7, 0.1, 1);
        transform: translateY(calc(100% - 60px));
        /* Chỉ chừa lại phần handle */
        z-index: 10000;
        padding-bottom: 30px;
    }

    .product-bottom-sheet.active {
        transform: translateY(0);
    }

    .sheet-handle-wrapper {
        width: 100%;
        padding: 15px;
        display: flex;
        justify-content: center;
        cursor: pointer;
    }

    .sheet-handle {
        width: 40px;
        height: 5px;
        background: #ddd;
        border-radius: 10px;
    }

    .sheet-content {
        padding: 0 20px;
        max-height: 60vh;
        overflow-y: auto;
    }

    .sheet-title {
        font-weight: 800;
        margin-bottom: 20px;
        font-size: 1.1rem;
    }

    /* Mobile Product Item */
    .m-product-item {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        text-decoration: none;
        color: #333;
        background: #f8f9fa;
        padding: 10px;
        border-radius: 12px;
    }

    .m-product-item img {
        width: 60px;
        height: 60px;
        object-fit: contain;
        background: white;
        border-radius: 8px;
    }

    .m-product-info h6 {
        font-size: 0.9rem;
        margin: 0;
        font-weight: 700;
    }

    .m-product-info .m-price {
        color: #ff4757;
        font-weight: 800;
        font-size: 0.9rem;
    }

    .floating-cart-btn {
        position: absolute;
        bottom: 80px;
        right: 20px;
        background: #ff4757;
        color: white;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #m-product-count {
        position: absolute;
        top: 0;
        right: 0;
        background: white;
        color: #ff4757;
        font-size: 0.7rem;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        font-weight: 800;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // 1. Swiper Mobile
    const mobileSwiper = new Swiper('.mobileVideoSwiper', {
        slidesPerView: 2.3,
        spaceBetween: 12,
        slidesOffsetAfter: 15,
    });

    // 2. Mở video full màn hình
    function openMobileVideo(videoUrl, products) {
        const overlay = document.getElementById('mobileVideoOverlay');
        const player = document.getElementById('mobilePlayer');
        const productList = document.getElementById('mobileProductList');
        const productCount = document.getElementById('m-product-count');

        // Reset trạng thái sheet
        document.getElementById('bottomSheet').classList.remove('active');

        // Load video
        player.src = videoUrl;
        overlay.style.display = 'flex';
        player.play();

        // Render sản phẩm
        productList.innerHTML = '';
        productCount.innerText = products.length;

        if (products && products.length > 0) {
            products.forEach(product => {
                let detailUrl = "{{ route('phone.detail', ':slug') }}".replace(':slug', product.slug);
                const price = (product.variants && product.variants.length > 0) ?
                    new Intl.NumberFormat('ko-KR').format(product.variants[0].price) + ' ₩' :
                    'Liên hệ';

                productList.innerHTML += `
                    <a href="${detailUrl}" class="m-product-item">
                        <img src="/storage/${product.main_image}" alt="${product.name}">
                        <div class="m-product-info">
                            <h6 class="text-truncate">${product.name}</h6>
                            <div class="m-price">${price}</div>
                        </div>
                        <i class="fas fa-chevron-right ms-auto align-self-center text-muted"></i>
                    </a>
                `;
            });
        }

        // Chặn scroll body khi mở video
        document.body.style.overflow = 'hidden';
    }

    // 3. Đóng video
    function closeMobileVideo() {
        const overlay = document.getElementById('mobileVideoOverlay');
        const player = document.getElementById('mobilePlayer');

        player.pause();
        player.src = "";
        overlay.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // 4. Đóng mở Bottom Sheet
    function toggleBottomSheet() {
        const sheet = document.getElementById('bottomSheet');
        sheet.classList.toggle('active');
    }

    // 5. Vuốt để đóng sheet (Hỗ trợ UX tốt hơn)
    let touchStart = 0;
    document.querySelector('.sheet-handle-wrapper').addEventListener('touchstart', e => {
        touchStart = e.touches[0].clientY;
    });

    document.querySelector('.sheet-handle-wrapper').addEventListener('touchmove', e => {
        let touchEnd = e.touches[0].clientY;
        if (touchEnd > touchStart + 10) { // Vuốt xuống
            document.getElementById('bottomSheet').classList.remove('active');
        }
    });
</script>
