<div id="contact-widget-desktop" class="contact-fixed-pc active"> <!-- Thêm class active ở đây -->


    <!-- Danh sách các nút con -->
    <div class="contact-list-pc" id="contact-list-pc">
            <!-- Tooltip (Mặc định ẩn opacity vì đang mở) -->
    <div class="contact-tooltip-pc active" id="tooltip-pc" style="opacity: 0;">Liên hệ với chúng tôi!</div>
        <!-- Nút Messenger -->
        <a href="javascript:void(0)" class="contact-bubble-pc messenger-color" onclick="openMessengerPC()"
            title="Chat qua Messenger">
            <img src="https://upload.wikimedia.org/wikipedia/commons/b/be/Facebook_Messenger_logo_2020.svg"
                alt="Messenger">
            <span class="label-text">Nhắn tin cho shop</span>
        </a>

        <!-- Nút Gọi Số 1 -->
        <a href="tel:01028288333" class="contact-bubble-pc phone-color" title="Gọi 010 2828 8333">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"
                    fill="white" />
            </svg>
            <span class="phone-text-pc">010 2828 8333</span>
        </a>

        <!-- Nút Gọi Số 2 -->
        <a href="tel:01082826886" class="contact-bubble-pc phone-color" title="Gọi 010 8282 6886">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"
                    fill="white" />
            </svg>
            <span class="phone-text-pc">010 8282 6886</span>
        </a>
    </div>

    <!-- Nút Tổng (Toggle Button) -->
    <div class="contact-bubble-pc toggle-main-pc" onclick="toggleContactPC()">
        <!-- icon Open ẩn đi -->
        <div class="icon-open-pc" style="display: none;"> 
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M21 11.5C21 16.1944 16.9706 20 12 20C10.5181 20 9.12457 19.6582 7.90616 19.055L3 20L4.10312 15.6841C3.39174 14.4578 3 13.0235 3 11.5C3 6.80558 7.02944 3 12 3C16.9706 3 21 6.80558 21 11.5Z"
                    stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <!-- icon Close hiện ra -->
        <div class="icon-close-pc" style="display: block;">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18M6 6L18 18" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>
    </div>
</div>

<style>
    .contact-fixed-pc {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
    }

    /* Hiệu ứng trượt cho danh sách nút */
    .contact-list-pc {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
        opacity: 0;
        transform: translateY(20px);
        pointer-events: none;
        transition: all 0.3s ease-in-out;
    }

    .contact-fixed-pc.active .contact-list-pc {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }

    .contact-bubble-pc {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        text-decoration: none;
        cursor: pointer;
        background: #fff;
        overflow: hidden;
    }

    /* Hover hiện chữ trên PC */
    .contact-bubble-pc:hover {
        width: auto;
        padding: 0 20px;
        border-radius: 30px;
    }

    .phone-text-pc,
    .label-text {
        display: none;
        color: white;
        font-weight: bold;
        margin-left: 10px;
        white-space: nowrap;
    }

    .messenger-color:hover .label-text {
        display: inline;
        color: #0084FF;
    }

    .phone-color:hover .phone-text-pc {
        display: inline;
        color: white;
    }

    .toggle-main-pc {
        background: #0084FF;
        border: 2px solid #fff;
    }

    .contact-fixed-pc.active .toggle-main-pc {
        background: #ff4757;
        transform: rotate(90deg);
    }

    .messenger-color {
        background: #fff;
    }

    .phone-color {
        background: #4CAF50;
    }

    .contact-bubble-pc img,
    .contact-bubble-pc svg {
        width: 30px;
        height: 30px;
        flex-shrink: 0;
    }

    .contact-tooltip-pc {
        background: #333;
        color: #fff;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 14px;
        margin-bottom: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        animation: bounce-pc 2s infinite;
    }

    @keyframes bounce-pc {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-5px);
        }

        60% {
            transform: translateY(-3px);
        }
    }
</style>

<script>
    // Hàm đóng/mở Widget trên Desktop
    function toggleContactPC() {
        const widget = document.getElementById('contact-widget-desktop');
        const iconOpen = document.querySelector('.icon-open-pc');
        const iconClose = document.querySelector('.icon-close-pc');
        const tooltip = document.getElementById('tooltip-pc');

        // Toggle class active
        widget.classList.toggle('active');

        // Kiểm tra xem sau khi toggle thì đang là active hay không
        if (widget.classList.contains('active')) {
            iconOpen.style.display = 'none';
            iconClose.style.display = 'block';
            if (tooltip) tooltip.style.opacity = '0';
        } else {
            iconOpen.style.display = 'block';
            iconClose.style.display = 'none';
            if (tooltip) tooltip.style.opacity = '1';
        }
    }

    function openMessengerPC() {
        const pageId = "100095174172336";
        window.open('https://m.me/' + pageId, '_blank');
    }
</script>
