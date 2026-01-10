<style>
    :root {
        --hs-navy: #1a222d;
        --hs-red: #ff4d6d;
        /* Màu Pink-Red chuẩn của bạn */
        --hs-white: #ffffff;
        --hs-gray: #f8fafc;
        --hs-border: #e2e8f0;
        --hs-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .hs-wrapper {
        padding: 30px 0;
        background-color: var(--hs-white);
        font-family: 'Inter', sans-serif;
    }

    .hs-container {
        max-width: 1240px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* --- Top Layout: Slider & Aside --- */
    .hs-top-grid {
        display: grid;
        grid-template-columns: 3fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .hs-main-slider {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--hs-shadow);
        background: #000;
    }

    .hs-main-slider img {
        width: 100%;
        height: 400px;
        /* Chiều cao cố định chuẩn desktop */
        object-fit: cover;
    }

    /* Tùy chỉnh Swiper */
    .hs-nav-btn {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        color: white !important;
        transition: 0.3s;
        opacity: 0;
        /* Ẩn mặc định, hiện khi hover */
    }

    .hs-main-slider:hover .hs-nav-btn {
        opacity: 1;
    }

    .hs-nav-btn:hover {
        background: var(--hs-red);
    }

    .hs-nav-btn:after {
        font-size: 18px !important;
        font-weight: bold;
    }

    .hs-dots .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 1;
    }

    .hs-dots .swiper-pagination-bullet-active {
        background: var(--hs-red) !important;
        width: 25px;
        border-radius: 5px;
    }

    /* Aside Promo */
    .hs-aside-promo {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--hs-shadow);
    }

    .hs-aside-link {
        display: block;
        height: 100%;
        position: relative;
    }

    .hs-aside-promo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.5s;
    }

    .hs-aside-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(26, 34, 45, 0.8), transparent);
        display: flex;
        align-items: flex-end;
        padding: 20px;
        opacity: 0;
        transition: 0.3s;
    }

    .hs-aside-overlay span {
        color: white;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
    }

    .hs-aside-promo:hover img {
        transform: scale(1.05);
    }

    .hs-aside-promo:hover .hs-aside-overlay {
        opacity: 1;
    }

    /* --- Hot Deals Grid (Cards) --- */
    .hs-hot-deals {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    .hs-deal-card {
        background: var(--hs-gray);
        border-radius: 20px;
        padding: 25px;
        text-decoration: none;
        position: relative;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
    }

    .hs-deal-card:hover {
        background: white;
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-color: var(--hs-red);
    }

    .hs-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background: var(--hs-navy);
        color: white;
        font-size: 10px;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 30px;
        letter-spacing: 1px;
    }

    .hs-card-content {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .hs-image {
        flex: 1;
        transition: 0.4s;
    }

    .hs-image img {
        max-width: 100%;
        height: 120px;
        object-fit: contain;
        filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.1));
    }

    .hs-deal-card:hover .hs-image {
        transform: scale(1.1) rotate(-5deg);
    }

    .hs-info {
        flex: 1.2;
        text-align: right;
    }

    .hs-brand {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .hs-name {
        font-size: 22px;
        font-weight: 800;
        color: var(--hs-navy);
        line-height: 1.1;
        margin-bottom: 10px;
    }

    .hs-price {
        font-size: 20px;
        color: var(--hs-red);
        font-weight: 900;
    }

    .hs-price span {
        font-size: 14px;
        font-weight: 400;
        color: #64748b;
    }

    /* Highlight Card (Card giữa) */
    .hs-featured {
        background: #fff1f2;
        border: 1px dashed var(--hs-red);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper('.hs-swiper-init', {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            effect: 'fade', // Chuyển cảnh kiểu mờ dần nhìn sẽ "sang" hơn trượt thông thường
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: '.hs-dots',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            speed: 1000,
        });
    });
</script>
