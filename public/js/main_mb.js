document.addEventListener('DOMContentLoaded', function () {
    // 1. Xử lý đóng mở Accordion Menu (Đa cấp)
    const toggles = document.querySelectorAll('.arrow-toggle');

    toggles.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation(); // Ngăn sự kiện nổi bọt lên link chính

            const parentLi = this.closest('li');
            
            // Nếu muốn chỉ mở 1 cái, đóng các cái khác cùng cấp (tùy chọn)
            /*
            const siblings = parentLi.parentElement.children;
            for (let sibling of siblings) {
                if (sibling !== parentLi) sibling.classList.remove('open');
            }
            */

            // Toggle class 'open' cho li hiện tại
            parentLi.classList.toggle('open');
        });
    });

    // 2. Xử lý đóng mở Drawer (Side Menu)
    const openBtn = document.getElementById('openMenu');
    const closeBtn = document.getElementById('closeMenu');
    const drawer = document.getElementById('sideDrawer');
    const overlay = document.getElementById('menuOverlay');

    if (openBtn && closeBtn && drawer && overlay) {
        function toggleMenu() {
            drawer.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.style.overflow = drawer.classList.contains('active') ? 'hidden' : '';
        }

        openBtn.addEventListener('click', toggleMenu);
        closeBtn.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);
    }
});