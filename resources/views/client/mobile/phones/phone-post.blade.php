<script>
    document.addEventListener('DOMContentLoaded', function() {
        let selectedCondition = null;
        let selectedSize = null;
        let selectedColor = null;
        let currentVariant = null;

        const pageId = "100095174172336";
        const phoneName = "{{ $phone->name }}";
        const currentUrl = window.location.href;

        const items = document.querySelectorAll('.ss-pd-v-item');
        const priceEl = document.getElementById('ss-pd-main-price');
        const stockEl = document.getElementById('ss-pd-stock-status');
        const skuEl = document.getElementById('ss-pd-sku');
        const buyBtn = document.getElementById('btn-add-to-cart');

        function updateDisplay() {
            currentVariant = VARIANT_DATA.find(v =>
                v.condition === selectedCondition &&
                v.size_id == selectedSize &&
                v.color_id == selectedColor
            );

            if (currentVariant) {
                priceEl.innerText = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(currentVariant.price);
                if (skuEl) skuEl.innerText = currentVariant.sku || 'N/A';
                if (stockEl) {
                    stockEl.innerText = currentVariant.stock > 0 ? `Còn hàng (${currentVariant.stock})` :
                        'Hết hàng';
                    stockEl.style.color = currentVariant.stock > 0 ? '#27ae60' : '#e74c3c';
                }
            }
        }

        items.forEach(item => {
            item.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                const value = this.getAttribute('data-value');
                const parentGroup = this.closest('.m-v-list');
                parentGroup.querySelectorAll('.ss-pd-v-item').forEach(btn => btn.classList
                    .remove('active'));
                this.classList.add('active');

                if (type === 'condition') selectedCondition = value;
                if (type === 'size') selectedSize = value;
                if (type === 'color') selectedColor = value;
                updateDisplay();
            });
        });

        // Hàm hỗ trợ copy nội dung cho iPhone (Dự phòng khi Messenger không tự điền tin nhắn)
        function copyToClipboard(text) {
            const tempInput = document.createElement("textarea");
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
        }

        buyBtn.addEventListener('click', function(e) {
            e.preventDefault();

            if (!selectedCondition || !selectedSize || !selectedColor || !currentVariant) {
                alert('Vui lòng chọn đầy đủ tùy chọn!');
                return;
            }

            const sizeText = document.querySelector(`.selector-size .ss-pd-v-item.active`).innerText
                .trim();
            const colorText = document.querySelector(`.selector-color .ss-pd-v-item.active`).innerText
                .trim();
            const conditionText = selectedCondition === 'new' ? 'Máy mới' : 'Máy cũ';

            // Tối ưu tin nhắn cho iOS: Không dùng ký tự lạ, hạn chế xuống dòng
            let message =
                `Mua: ${phoneName} (${conditionText}, ${sizeText}, ${colorText}). Gia: ${priceEl.innerText}. Link: ${currentUrl}`;
            const encodedMessage = encodeURIComponent(message);

            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

            if (isIOS) {
                // 1. Copy nội dung vào bộ nhớ đệm (Trường hợp Messenger mở ra mà không có chữ, khách chỉ cần dán)
                copyToClipboard(message);

                // 2. Sử dụng URL Scheme đặc biệt cho iPhone để ép mở LUỒNG CHAT THẬT (Fix lỗi Ghost Chat)
                // fb-messenger://user-thread/ là cách an toàn nhất trên iOS
                const nativeUrl = `fb-messenger://user-thread/${pageId}`;
                const webUrl = `https://www.messenger.com/t/${pageId}/?text=${encodedMessage}`;

                // Thử mở App trước
                window.location.href = nativeUrl;

                // Fallback: Nếu 1 giây sau không thấy chuyển động, mở bản web messenger
                setTimeout(function() {
                    if (document.hasFocus()) {
                        window.location.href = webUrl;
                    }
                }, 1000);

                // Thông báo nhỏ cho khách hàng iPhone
                console.log("iOS Detected: Thread forced. Message copied to clipboard.");
            } else {
                // Android và Desktop dùng m.me vẫn là tốt nhất
                const messengerUrl = `https://m.me/${pageId}?text=${encodedMessage}`;
                window.location.href = messengerUrl;
            }
        });
    });
</script>

<style>
    /* Highlight nút khi được chọn */
    .ss-pd-v-item.active {
        border: 2px solid #ef4444 !important;
        color: #ef4444 !important;
        background-color: #fef2f2 !important;
        position: relative;
    }

    /* Thêm icon check nhỏ nếu muốn giống mobile style hiện đại */
    .ss-pd-v-item.active::after {
        content: '✓';
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ef4444;
        color: white;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Đảm bảo khung thông tin máy cũ hiện thị đẹp trên mobile */
    .m-pd-used-card {
        display: none;
        /* Ẩn mặc định */
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
        padding: 12px;
        margin: 15px 0;
        justify-content: space-around;
    }

    .m-used-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 13px;
    }

    .m-used-item i {
        color: #3b82f6;
        margin-bottom: 4px;
    }
</style>
