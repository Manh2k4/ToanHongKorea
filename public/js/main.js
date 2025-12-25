document.addEventListener('DOMContentLoaded', function () {
    
    // 1. Khởi tạo Swiper ngay khi trang load xong (Không đợi click)
    const swiper = new Swiper('.banner-swiper', {
        loop: true,
        effect: 'slide',
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        speed: 800,
    });

    // 2. Xử lý sự kiện Click (Chỉ dành cho các logic đóng/mở menu)
    document.addEventListener('click', function (event) {
        const dropdown = document.querySelector('.user-dropdown-content');
        const trigger = document.querySelector('.dropdown-trigger');

        // Logic đóng menu khi click ra ngoài
        if (dropdown && trigger) {
            if (!trigger.contains(event.target) && !dropdown.contains(event.target)) {
                // Ví dụ: dropdown.classList.remove('active');
                // Hoặc ẩn dropdown tùy theo cách bạn code CSS
                dropdown.style.display = 'none'; 
            }
        }
    });

    // 3. Logic mở menu khi click vào trigger (Nếu bạn không dùng hover)
    const triggerBtn = document.querySelector('.dropdown-trigger');
    if(triggerBtn) {
        triggerBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = document.querySelector('.user-dropdown-content');
            if(dropdown) {
                dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
            }
        });
    }

});