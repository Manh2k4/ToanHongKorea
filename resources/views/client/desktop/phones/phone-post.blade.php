<script>
    document.addEventListener('DOMContentLoaded', function() {
        let selectedCondition = null,
            selectedSize = null,
            selectedColor = null,
            currentVariant = null;

        // --- CẤU HÌNH ---
        const pageId = "100090503628117";

        const phoneName = "{{ $phone->name }}";

        // 1. Logic chọn biến thể (Giữ nguyên của bạn)
        const items = document.querySelectorAll('.ss-pd-v-item');
        items.forEach(item => {
            item.addEventListener('click', function() {
                const type = this.dataset.type;
                const value = this.dataset.value;

                document.querySelectorAll(`.ss-pd-v-item[data-type="${type}"]`).forEach(btn =>
                    btn.classList.remove('active'));
                this.classList.add('active');

                if (type === 'condition') selectedCondition = value;
                if (type === 'size') selectedSize = value;
                if (type === 'color') selectedColor = value;

                currentVariant = VARIANT_DATA.find(v =>
                    v.condition === selectedCondition &&
                    v.size_id == selectedSize &&
                    v.color_id == selectedColor
                );

                if (typeof updateDisplay === "function") updateDisplay();
            });
        });

        // 2. XỬ LÝ NÚT MUA NGAY
        const buyBtn = document.getElementById('btn-buy-now');
        if (buyBtn) {
            buyBtn.onclick = function(e) {
                e.preventDefault();

                // Kiểm tra đã chọn đủ chưa
                if (!selectedCondition || !selectedSize || !selectedColor || !currentVariant) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thông báo',
                        text: 'Vui lòng chọn đầy đủ Tình trạng, Dung lượng và Màu sắc!',
                        confirmButtonColor: '#0084FF'
                    });
                    return;
                }

                // Lấy thông tin text từ giao diện
                const sizeText = document.querySelector(`.ss-pd-v-item[data-type="size"].active`).innerText
                    .trim();
                const colorText = document.querySelector(`.ss-pd-v-item[data-type="color"].active`)
                    .innerText.trim();
                const price = document.getElementById('ss-pd-main-price').innerText;

                // 3. TẠO NỘI DUNG TIN NHẮN
                let message = `Chào Shop, mình muốn mua điện thoại:\n`;
                message += `📱 Sản phẩm: ${phoneName}\n`;
                message += `✨ Tình trạng: ${selectedCondition == 'new' ? 'Mới 100%' : 'Like New'}\n`;
                message += `💾 Cấu hình: ${sizeText} - ${colorText}\n`;
                message += `💰 Giá: ${price}\n`;
                message += `🔗 Link: ${window.location.href}`;

                // Mã hóa tin nhắn để đưa vào URL
                const encodedMessage = encodeURIComponent(message);
                const messengerUrl = `https://m.me/${pageId}?text=${encodedMessage}`;

                // 4. HIỂN THỊ THÔNG BÁO XÁC NHẬN
                Swal.fire({
                    title: 'Xác nhận đơn hàng',
                    html: `Hệ thống sẽ mở Messenger để gửi đơn hàng:<br><b>${phoneName} (${sizeText})</b>`,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#0084FF',
                    cancelButtonColor: '#6e7881',
                    confirmButtonText: 'Mở Messenger ngay',
                    cancelButtonText: 'Để sau',
                    showClass: {
                        popup: ''
                    }, // Tắt hiệu ứng để mượt hơn trên mobile
                    hideClass: {
                        popup: ''
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kiểm tra thiết bị để có cách mở phù hợp
                        const isIphone = navigator.userAgent.match(/iPhone|iPad|iPod/i);

                        if (isIphone) {
                            // iPhone dùng href để kích hoạt App trực tiếp
                            window.location.href = messengerUrl;
                        } else {
                            // Desktop/Android dùng window.open
                            window.open(messengerUrl, '_blank');
                        }
                    }
                });
            };
        }
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
