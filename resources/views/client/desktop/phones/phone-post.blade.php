<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Khai báo các biến
        let selectedCondition = null;
        let selectedSize = null;
        let selectedColor = null;
        let currentVariant = null;

        const pageId = "100090503628117";
        const phoneName = "{{ $phone->name }}";
        const currentUrl = window.location.href;

        const items = document.querySelectorAll('.ss-pd-v-item');
        const priceEl = document.getElementById('ss-pd-main-price');
        const stockEl = document.getElementById('ss-pd-stock-status');
        const skuEl = document.getElementById('ss-pd-sku');
        const buyBtn = document.getElementById('btn-buy-now');

        // Kiểm tra xem nút có tồn tại không để tránh lỗi null
        if (!buyBtn) {
            console.error("Không tìm thấy nút #btn-buy-now trong DOM");
            return;
        }

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
                skuEl.innerText = currentVariant.sku || 'N/A';
                stockEl.innerText = currentVariant.stock > 0 ? `Còn hàng (${currentVariant.stock})` :
                'Hết hàng';
                stockEl.style.color = currentVariant.stock > 0 ? '#27ae60' : '#e74c3c';

                const usedInfo = document.getElementById('ss-pd-used-info');
                if (selectedCondition !== 'new' && usedInfo) {
                    usedInfo.style.display = 'block';
                    document.getElementById('val-pin').innerText = (currentVariant.battery_health || 'N/A') +
                        '%';
                    document.getElementById('val-sac').innerText = currentVariant.charging_count || 'N/A';
                } else if (usedInfo) {
                    usedInfo.style.display = 'none';
                }
            } else {
                priceEl.innerText = "Chưa có giá";
                stockEl.innerText = "Vui lòng chọn đủ tùy chọn";
            }
        }

        items.forEach(item => {
            item.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                const value = this.getAttribute('data-value');

                document.querySelectorAll(`.ss-pd-v-item[data-type="${type}"]`).forEach(btn =>
                    btn.classList.remove('active'));
                this.classList.add('active');

                if (type === 'condition') selectedCondition = value;
                if (type === 'size') selectedSize = value;
                if (type === 'color') selectedColor = value;

                updateDisplay();
            });
        });

        // 2. Xử lý nút MUA NGAY (Dùng cơ chế dự phòng)
        buyBtn.onclick = function(e) {
            e.preventDefault();
            console.log("Nút đã được bấm!");

            if (!selectedCondition || !selectedSize || !selectedColor) {
                alert('Vui lòng chọn đầy đủ Tình trạng, Dung lượng và Màu sắc!');
                return;
            }

            if (!currentVariant) {
                alert('Phiên bản này hiện không có sẵn!');
                return;
            }

            const sizeText = document.querySelector(`.ss-pd-v-item[data-type="size"].active`).innerText
                .trim();
            const colorText = document.querySelector(`.ss-pd-v-item[data-type="color"].active`).innerText
                .trim();
            const conditionText = selectedCondition === 'new' ? 'Máy mới 100%' : 'Máy cũ/Like New';

            let message =
                `Chào Shop, mình muốn mua:\n📱 ${phoneName}\n✨ ${conditionText}\n💾 ${sizeText} - ${colorText}\n💰 Giá: ${priceEl.innerText}\n🆔 SKU: ${currentVariant.sku}\n🔗 ${currentUrl}`;

            // HÀM COPY DỰ PHÒNG (Dùng được cả khi không có HTTPS/SSL)
            function fallbackCopyTextToClipboard(text) {
                var textArea = document.createElement("textarea");
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    alert('Đã copy thông tin máy! Hãy dán (Ctrl+V) vào khung chat để shop tư vấn nhé.');
                } catch (err) {
                    console.error('Lỗi khi copy: ', err);
                }
                document.body.removeChild(textArea);
                // Mở Messenger sau khi copy
                window.open(`https://m.me/${pageId}`, '_blank');
            }

            if (!navigator.clipboard) {
                fallbackCopyTextToClipboard(message);
            } else {
                navigator.clipboard.writeText(message).then(function() {
                    alert('Đã copy thông tin máy! Hãy dán (Ctrl+V) vào khung chat nhé.');
                    window.open(`https://m.me/${pageId}`, '_blank');
                }, function(err) {
                    fallbackCopyTextToClipboard(message);
                });
            }
        };
    });
</script>
<style>
    /* Thêm một chút CSS để nhận diện nút đang chọn */
    .ss-pd-v-item.active {
        border: 2px solid #ef4444 !important;
        color: #ef4444 !important;
        background-color: #fef2f2;
    }

    .ss-pd-btn-buy {
        background: #0084FF;
        /* Màu xanh Messenger */
        color: white;
        border: none;
        padding: 15px 25px;
        font-weight: bold;
        cursor: pointer;
        border-radius: 8px;
    }

    .ss-pd-btn-buy:hover {
        background: #0073e6;
    }
</style>
