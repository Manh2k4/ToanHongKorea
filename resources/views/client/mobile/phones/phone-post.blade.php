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
            if (typeof VARIANT_DATA === 'undefined') return;

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
                    stockEl.innerText = currentVariant.stock > 0 ? `Còn hàng (${currentVariant.stock})` : 'Hết hàng';
                    stockEl.style.color = currentVariant.stock > 0 ? '#27ae60' : '#e74c3c';
                }

                const usedInfo = document.getElementById('ss-pd-used-info');
                if (selectedCondition !== 'new' && usedInfo) {
                    usedInfo.style.display = 'flex';
                    const pin = document.getElementById('val-pin');
                    const sac = document.getElementById('val-sac');
                    if(pin) pin.innerText = (currentVariant.battery_health || '99') + '%';
                    if(sac) sac.innerText = currentVariant.charging_count || '0';
                } else if (usedInfo) {
                    usedInfo.style.display = 'none';
                }
            }
        }

        items.forEach(item => {
            item.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                const value = this.getAttribute('data-value');
                const parentGroup = this.closest('.m-v-list');
                
                if (parentGroup) {
                    parentGroup.querySelectorAll('.ss-pd-v-item').forEach(btn => btn.classList.remove('active'));
                }
                this.classList.add('active');

                if (type === 'condition') selectedCondition = value;
                if (type === 'size') selectedSize = value;
                if (type === 'color') selectedColor = value;

                updateDisplay();
            });
        });

        if (buyBtn) {
            buyBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Kiểm tra đủ điều kiện
                if (!selectedCondition || !selectedSize || !selectedColor || !currentVariant) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thông báo',
                        text: 'Vui lòng chọn đầy đủ Tình trạng, Dung lượng và Màu sắc!',
                        confirmButtonColor: '#0084FF'
                    });
                    return;
                }

                // FIX LỖI SELECTOR: Lấy text trực tiếp từ các item đang có class active
                // Không dùng .selector-size vì có thể class đó không tồn tại trong HTML mobile của bạn
                let sizeText = "";
                let colorText = "";
                
                document.querySelectorAll('.ss-pd-v-item.active').forEach(el => {
                    if(el.getAttribute('data-type') === 'size') sizeText = el.innerText.trim();
                    if(el.getAttribute('data-type') === 'color') colorText = el.innerText.trim();
                });

                const conditionText = selectedCondition === 'new' ? 'Máy mới 100%' : 'Máy cũ/Like New';
                const price = priceEl.innerText;
                const sku = currentVariant.sku || 'N/A';

                let message = `Chào Shop, mình muốn mua điện thoại:\n`;
                message += `📱 Sản phẩm: ${phoneName}\n`;
                message += `✨ Tình trạng: ${conditionText}\n`;
                message += `💾 Dung lượng: ${sizeText}\n`;
                message += `🎨 Màu sắc: ${colorText}\n`;
                message += `💰 Giá: ${price}\n`;
                message += `🆔 SKU: ${sku}\n`;
                message += `🔗 Link: ${currentUrl}`;

                const encodedMessage = encodeURIComponent(message);
                const messengerUrl = `https://m.me/${pageId}?text=${encodedMessage}`;

                // Tối ưu Swal: Tắt animation để hiện nhanh, tránh khựng
                Swal.fire({
                    title: 'Xác nhận đơn hàng',
                    html: `Bạn đang chọn mua <b>${phoneName}</b>.<br>Hệ thống sẽ mở Messenger để gửi đơn hàng!`,
                    icon: 'info',
                    showCancelButton: false,
                    allowOutsideClick: false,
                    confirmButtonColor: '#0084FF',
                    confirmButtonText: 'Gửi ngay',
                    showClass: { popup: '' }, // Tắt hiệu ứng hiện để mượt hơn
                    hideClass: { popup: '' }  // Tắt hiệu ứng ẩn
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Dùng location.assign để trình duyệt mobile xử lý tốt hơn href
                        window.location.assign(messengerUrl);
                    }
                });
            });
        }
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
