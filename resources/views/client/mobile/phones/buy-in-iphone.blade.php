<script>
    (function() {
        // --- 1. KHỞI TẠO BIẾN TRẠNG THÁI ---
        let selectedCondition = null;
        let selectedSize = null;
        let selectedColor = null;
        let currentVariant = null;

        const pageUsername = "anhtoan270189";
        const phoneName = "{{ $phone->name }}";
        const currentUrl = window.location.href;

        // Các phần tử DOM
        const priceEl = document.getElementById('ss-pd-main-price');
        const stockEl = document.getElementById('ss-pd-stock-status');
        const skuEl = document.getElementById('ss-pd-sku');
        const usedInfo = document.getElementById('ss-pd-used-info');

        // --- 2. HÀM TẠO MÃ REF (Tracking cho iOS) ---
        function generateRefCode(variant) {
            const nameSlug = "{{ Str::slug($phone->name, '_') }}";
            const sizeText = document.querySelector(`.ss-pd-v-item[data-type="size"].active`)?.innerText.trim()
                .replace(/\s+/g, '') || '0';
            const vId = variant ? variant.id : 'IPHONE_REQ';
            // Tiền tố I_ để nhận diện khách đến từ iPhone
            return `I_MUA_${vId}_${nameSlug}_${sizeText}`.toUpperCase();
        }

        // --- 3. HÀM TỰ ĐỘNG CHỌN BIẾN THỂ RẺ NHẤT ---
        function selectDefaultVariant() {
            if (typeof VARIANT_DATA !== 'undefined' && VARIANT_DATA.length > 0) {
                const cheapest = VARIANT_DATA.reduce((min, v) => v.price < min.price ? v : min, VARIANT_DATA[0]);

                setTimeout(() => {
                    const btnCond = document.querySelector(
                        `.ss-pd-v-item[data-type="condition"][data-value="${cheapest.condition}"]`);
                    const btnSize = document.querySelector(
                        `.ss-pd-v-item[data-type="size"][data-value="${cheapest.size_id}"]`);
                    const btnColor = document.querySelector(
                        `.ss-pd-v-item[data-type="color"][data-value="${cheapest.color_id}"]`);

                    if (btnCond) btnCond.click();
                    if (btnSize) btnSize.click();
                    if (btnColor) btnColor.click();
                }, 150);
            }
        }

        // --- 4. CẬP NHẬT GIAO DIỆN ---
        function updateDisplay() {
            if (typeof VARIANT_DATA === 'undefined') return;

            currentVariant = VARIANT_DATA.find(v =>
                v.condition === selectedCondition &&
                v.size_id == selectedSize &&
                v.color_id == selectedColor
            );

            if (currentVariant) {
                const formattedPrice = new Intl.NumberFormat('vi-VN').format(currentVariant.price) + 'w';
                if (priceEl) priceEl.innerText = formattedPrice;
                if (skuEl) skuEl.innerText = currentVariant.sku || 'N/A';
                if (stockEl) {
                    stockEl.innerText = currentVariant.stock > 0 ? "Sẵn hàng tại shop" : "Hàng đặt trước";
                    stockEl.style.color = currentVariant.stock > 0 ? '#27ae60' : '#f39c12';
                }

                if (selectedCondition !== 'new' && usedInfo) {
                    usedInfo.style.display = 'flex';
                    document.getElementById('val-pin').innerText = (currentVariant.battery_health || '9x') + '%';
                    document.getElementById('val-sac').innerText = currentVariant.charging_count || 'Ít';
                } else if (usedInfo) {
                    usedInfo.style.display = 'none';
                }
            } else {
                if (priceEl) priceEl.innerText = "Giá: Liên hệ";
                if (stockEl) {
                    stockEl.innerText = "Hàng đặt riêng (Vui lòng chat)";
                    stockEl.style.color = "#3498db";
                }
                if (usedInfo) usedInfo.style.display = 'none';
            }
        }

        // --- 5. LẮNG NGHE SỰ KIỆN ---
        document.addEventListener('click', function(e) {
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
                return;
            }

            // XỬ LÝ NÚT MUA QUA MESSENGER
            const buyBtn = e.target.closest('#btn-add-to-cart');
            if (buyBtn) {
                e.preventDefault();

                if (!selectedCondition || !selectedSize || !selectedColor) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thiếu thông tin',
                        text: 'Vui lòng chọn đầy đủ các tùy chọn máy!',
                        confirmButtonColor: '#0084FF'
                    });
                    return;
                }

                let sizeText = document.querySelector('.ss-pd-v-item.active[data-type="size"]')?.innerText
                    .trim() || "";
                let colorText = document.querySelector('.ss-pd-v-item.active[data-type="color"]')?.innerText
                    .trim() || "";
                const conditionLabel = selectedCondition === 'new' ? 'Máy mới 100%' : 'Like New/99%';

                const refCode = generateRefCode(currentVariant);
                let message = `Chào Shop, mình muốn tư vấn mua máy:\n`;
                message += `- Sản phẩm: ${phoneName}\n`;
                message += `- Tình trạng: ${conditionLabel}\n`;
                message += `- Cấu hình: ${sizeText} - ${colorText}\n`;
                message += `- Giá: ${priceEl ? priceEl.innerText : 'Liên hệ'}\n`;
                message += `- Link: ${currentUrl}`;

                const messengerUrl =
                    `https://m.me/${pageUsername}?ref=${refCode}&text=${encodeURIComponent(message)}`;

                Swal.fire({
                    title: 'Kết nối Messenger',
                    html: `Mở chat để nhận tư vấn cho bản <b>${sizeText}</b> nhé!`,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#0084FF',
                    confirmButtonText: 'Mở Messenger',
                    cancelButtonText: 'Để sau',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // --- GỬI THỐNG KÊ LÊN SERVER (QUAN TRỌNG) ---
                        fetch("{{ route('track.messenger') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                type: 'phone',
                                product_id: "{{ $phone->id }}",
                                variant_id: currentVariant ? currentVariant.id :
                                    null,
                                product_name: "{{ $phone->name }}",
                                product_slug: "{{ $phone->slug }}",
                                variant_info: `${conditionLabel} | ${sizeText} | ${colorText}`,
                                price: currentVariant ? currentVariant.price : 0
                            })
                        });

                        // Deep Link cho iOS
                        window.location.href = messengerUrl;
                    }
                });
            }
        });

        // Khởi tạo
        if (document.readyState === 'complete') {
            selectDefaultVariant();
        } else {
            window.addEventListener('load', selectDefaultVariant);
        }
    })();
</script>

<style>
    /* Tối ưu hóa phản hồi chạm cho iPhone */
    #btn-add-to-cart,
    .ss-pd-v-item {
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
        transition: transform 0.1s ease;
    }

    .ss-pd-v-item:active {
        transform: scale(0.96);
        /* Hiệu ứng nhấn nhẹ trên iOS */
    }

    /* Hiệu ứng active rõ ràng hơn */
    .ss-pd-v-item.active {
        border: 2px solid #d70018 !important;
        background-color: #fff4f5 !important;
        font-weight: bold;
    }
</style>
