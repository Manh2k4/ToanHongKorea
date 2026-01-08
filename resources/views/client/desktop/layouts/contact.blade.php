<div id="contact-widget-desktop" class="contact-fixed-pc active"> <!-- Bỏ active nếu muốn mặc định đóng -->
    <!-- 1. Danh sách nút con -->
    <div class="contact-list-pc" id="contact-list-pc">
        <a href="javascript:void(0)" class="contact-bubble-pc messenger-color" onclick="openMessengerPC()">
            <img src="https://upload.wikimedia.org/wikipedia/commons/b/be/Facebook_Messenger_logo_2020.svg"
                alt="Messenger">
            <span class="label-text">Nhắn tin cho shop</span>
        </a>

        <a href="tel:01028288333" class="contact-bubble-pc phone-color">
            <svg viewBox="0 0 24 24" fill="white">
                <path
                    d="M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
            </svg>
            <span class="label-text">010 2828 8333</span>
        </a>

        <a href="tel:01082826886" class="contact-bubble-pc phone-color">
            <svg viewBox="0 0 24 24" fill="white">
                <path
                    d="M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
            </svg>
            <span class="label-text">010 8282 6886</span>
        </a>
    </div>

    <!-- 2. Nút Toggle chính và Tooltip -->
    <div class="toggle-wrapper-pc">
        <div class="contact-tooltip-pc" id="tooltip-pc">Liên hệ với chúng tôi!</div>
        <div class="contact-bubble-pc toggle-main-pc" onclick="toggleContactPC()">
            <div class="icon-open-pc">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path
                        d="M21 11.5C21 16.1944 16.9706 20 12 20C10.5181 20 9.12457 19.6582 7.90616 19.055L3 20L4.10312 15.6841C3.39174 14.4578 3 13.0235 3 11.5C3 6.80558 7.02944 3 12 3C16.9706 3 21 6.80558 21 11.5Z" />
                </svg>
            </div>
            <div class="icon-close-pc" style="display: none;">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M18 6L6 18M6 6L18 18" />
                </svg>
            </div>
        </div>
    </div>
</div>

<style>
    .contact-fixed-pc {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 15px;
        pointer-events: none;
        /* Tránh đè vùng click của web */
    }

    .contact-list-pc {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    /* Mở danh sách */
    .contact-fixed-pc.active .contact-list-pc {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
        pointer-events: auto;
    }

    /* Tooltip xử lý đặc biệt */
    .toggle-wrapper-pc {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .contact-tooltip-pc {
        position: absolute;
        right: 70px;
        /* Đẩy sang trái của nút chính */
        background: rgba(0, 0, 0, 0.8);
        color: #fff;
        padding: 8px 15px;
        border-radius: 8px;
        font-size: 13px;
        white-space: nowrap;
        pointer-events: none;
        transition: all 0.3s ease;
        opacity: 1;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Khi đang MỞ menu (active) thì phải ẨN tooltip */
    .contact-fixed-pc.active .contact-tooltip-pc {
        opacity: 0;
        transform: translateX(10px);
        visibility: hidden;
    }

    /* Các nút Bubble */
    .contact-bubble-pc {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        pointer-events: auto;
        overflow: hidden;
        position: relative;
    }

    .contact-bubble-pc:hover:not(.toggle-main-pc) {
        width: 200px;
        /* Giãn nút mượt mà */
        border-radius: 30px;
        justify-content: flex-start;
        padding-left: 15px;
    }

    .label-text {
        position: absolute;
        left: 55px;
        opacity: 0;
        white-space: nowrap;
        font-weight: 600;
        transition: opacity 0.2s;
        color: #333;
    }

    .contact-bubble-pc:hover .label-text {
        opacity: 1;
    }

    .phone-color .label-text {
        color: #fff;
    }

    .phone-color {
        background: #4CAF50;
    }

    .messenger-color img {
        width: 32px;
        height: 32px;
    }

    .phone-color svg {
        width: 28px;
        height: 28px;
    }

    /* Nút đỏ Toggle */
    .toggle-main-pc {
        background: #FF4757;
        border: 2px solid #fff;
    }

    /* Hiệu ứng xoay icon */
    .contact-fixed-pc.active .toggle-main-pc {
        transform: rotate(135deg);
        /* Xoay tạo dấu X */
        background: #333;
    }
</style>

<script>
    function toggleContactPC() {
        const widget = document.getElementById('contact-widget-desktop');
        const iconOpen = document.querySelector('.icon-open-pc');
        const iconClose = document.querySelector('.icon-close-pc');

        const isActive = widget.classList.toggle('active');

        // Logic thay đổi Icon (Nếu bạn không dùng hiệu ứng xoay CSS)
        if (isActive) {
            if (iconOpen) iconOpen.style.display = 'none';
            if (iconClose) iconClose.style.display = 'block';
        } else {
            if (iconOpen) iconOpen.style.display = 'block';
            if (iconClose) iconClose.style.display = 'none';
        }
    }

    function openMessengerPC() {
        window.open('https://m.me/hanofarmer', '_blank');
    }
</script>
