<script>
    (function() {
        // Biến cục bộ để lưu trạng thái
        let selectedCondition = null;
        let selectedSize = null;
        let selectedColor = null;
        let currentVariant = null;

        const pageUsername = "hanofarmer"; // Đã thay ID bằng Username
        const phoneName = "{{ $phone->name }}";
        const currentUrl = window.location.href;

        function updateDisplay() {
            if (typeof VARIANT_DATA === 'undefined') return;

            currentVariant = VARIANT_DATA.find(v =>
                v.condition === selectedCondition &&
                v.size_id == selectedSize &&
                v.color_id == selectedColor
            );

            const priceEl = document.getElementById('ss-pd-main-price');
            const stockEl = document.getElementById('ss-pd-stock-status');
            const skuEl = document.getElementById('ss-pd-sku');

            if (currentVariant && priceEl) {
                priceEl.innerText = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(currentVariant.price);

                if (skuEl) skuEl.innerText = currentVariant.sku || 'N/A';

                const usedInfo = document.getElementById('ss-pd-used-info');
                if (selectedCondition !== 'new' && usedInfo) {
                    usedInfo.style.display = 'flex';
                    const pin = document.getElementById('val-pin');
                    const sac = document.getElementById('val-sac');
                    if (pin) pin.innerText = (currentVariant.battery_health || '99') + '%';
                    if (sac) sac.innerText = currentVariant.charging_count || '0';
                } else if (usedInfo) {
                    usedInfo.style.display = 'none';
                }
            }
        }

        // Lắng nghe sự kiện Click trên toàn document (Event Delegation)
        document.addEventListener('click', function(e) {

            // 1. Xử lý khi click vào các option (Tình trạng, màu sắc, dung lượng)
            const item = e.target.closest('.ss-pd-v-item');
            if (item) {
                const type = item.getAttribute('data-type');
                const value = item.getAttribute('data-value');
                const parentGroup = item.closest('.m-v-list');

                if (parentGroup) {
                    parentGroup.querySelectorAll('.ss-pd-v-item').forEach(btn => btn.classList.remove(
                        'active'));
                }
                item.classList.add('active');

                if (type === 'condition') selectedCondition = value;
                if (type === 'size') selectedSize = value;
                if (type === 'color') selectedColor = value;

                updateDisplay();
                return; // Thoát để không chạy xuống xử lý button
            }

            // 2. Xử lý khi click vào nút MUA NGAY (ID: btn-add-to-cart)
            const buyBtn = e.target.closest('#btn-add-to-cart');
            if (buyBtn) {
                e.preventDefault();

                if (!selectedCondition || !selectedSize || !selectedColor || !currentVariant) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thông báo',
                        text: 'Vui lòng chọn đầy đủ Tình trạng, Dung lượng và Màu sắc!',
                        confirmButtonColor: '#0084FF'
                    });
                    return;
                }

                // Lấy Text hiển thị
                let sizeText = "";
                let colorText = "";
                document.querySelectorAll('.ss-pd-v-item.active').forEach(el => {
                    if (el.getAttribute('data-type') === 'size') sizeText = el.innerText.trim();
                    if (el.getAttribute('data-type') === 'color') colorText = el.innerText.trim();
                });

                const conditionText = selectedCondition === 'new' ? 'Máy mới 100%' : 'Máy cũ/Like New';
                const priceText = document.getElementById('ss-pd-main-price').innerText;
                const sku = currentVariant.sku || 'N/A';

                let message = `Chào Shop, mình muốn mua:\n`;
                message += `Sản phẩm: ${phoneName}\n`;
                message += `Tình trạng: ${conditionText}\n`;
                message += `Dung lượng: ${sizeText}\n`;
                message += `Màu sắc: ${colorText}\n`;
                message += `Giá: ${priceText}\n`;
                message += `SKU: ${sku}\n`;
                message += `Link: ${currentUrl}`;

                const encodedMessage = encodeURIComponent(message);
                const messengerUrl = `https://m.me/${pageUsername}?text=${encodedMessage}`;

                Swal.fire({
                    title: 'Xác nhận đơn hàng',
                    html: `Hệ thống sẽ mở Messenger để gửi đơn hàng cho <b>${phoneName}</b>`,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#0084FF',
                    confirmButtonText: 'Mở Messenger',
                    cancelButtonText: 'Để sau',
                    showClass: {
                        popup: ''
                    },
                    hideClass: {
                        popup: ''
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Dùng location.assign hoặc href đều được trên iOS nếu gọi từ event trực tiếp
                        window.location.href = messengerUrl;
                    }
                });
            }
        });
    })();
</script>

<style>
    #btn-add-to-cart {
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
}
</style>
