@extends('client.desktop.layouts.app')

@section('content')
    <section class="contact-section">
        <div class="contact-container">
            <div class="contact-grid">

                <!-- Bên trái: Form liên hệ -->
                <div class="contact-form-side">
                    <h2 class="contact-title">Liên Hệ</h2>
                    <p class="contact-subtitle">Hãy để lại thông tin, chúng tôi sẽ phản hồi bạn trong vòng 24h.</p>

                    <form action="#" method="POST" class="main-contact-form">
                        <div class="input-group">
                            <input type="text" name="name" placeholder="Họ và tên của bạn" required>
                        </div>

                        <div class="input-row">
                            <div class="input-group">
                                <input type="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="input-group">
                                <input type="tel" name="phone" placeholder="Số điện thoại" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <select name="service" required>
                                <option value="" disabled selected>Vui lòng chọn dịch vụ mà bạn quan tâm *</option>
                                <option value="tu-van">Tư vấn mua điện thoại</option>
                                <option value="bao-hanh">Hỗ trợ bảo hành</option>
                                <option value="gop-y">Góp ý dịch vụ</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <textarea name="message" rows="4" placeholder="Yêu cầu cụ thể (nếu có)"></textarea>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn-submit">
                                <span>Gửi yêu cầu</span>
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Bên phải: Bản đồ -->
                <div class="contact-map-side">
                    <div class="map-wrapper">
                        <!-- Thay src bằng link bản đồ thực tế của bạn -->
                        <iframe
                            src=""
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                    <div class="contact-info-mini">
                        <div class="info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span></span>
                        </div>
                        <div class="info-item">
                            <i class="fa-solid fa-phone"></i>
                            <span></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@include('pages.contact-lib')
