@extends('admin.layouts')

@section('title', 'Thêm Video Review Mới')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Thêm Video Review</h1>
            <a href="{{ route('admin.videos.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm"></i> Quay lại danh sách
            </a>
        </div>

        <form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data" id="uploadVideoForm">
            @csrf
            <div class="row">
                <!-- Cột trái: Thông tin chính -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4 border-0">
                        <div class="card-header py-3 bg-white">
                            <h6 class="m-0 font-weight-bold text-primary">Thông tin Video & Sản phẩm</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-dark">Gắn sản phẩm liên quan <span
                                        class="text-danger">*</span></label>
                                {{-- QUAN TRỌNG: Đổi name thành phone_ids[] và thêm thuộc tính multiple --}}
                                <select name="phone_ids[]"
                                    class="form-control select2 @error('phone_ids') is-invalid @enderror"
                                    multiple="multiple" data-placeholder="Tìm và chọn một hoặc nhiều điện thoại..."
                                    required>
                                    @foreach ($phones as $phone)
                                        <option value="{{ $phone->id }}"
                                            {{ is_array(old('phone_ids')) && in_array($phone->id, old('phone_ids')) ? 'selected' : '' }}>
                                            {{ $phone->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted mt-2 d-block">
                                    <i class="fas fa-question-circle"></i> Bạn có thể chọn nhiều sản phẩm nếu đây là video
                                    tổng hợp.
                                </small>
                                @error('phone_ids')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-dark">Tiêu đề Video Review <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Ví dụ: Livestream báo giá iPhone/Samsung ngày 20/01..."
                                    value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Tải lên Video (MP4/MOV, tối đa 200MB) <span
                                        class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="video"
                                        class="custom-file-input @error('video') is-invalid @enderror" id="videoInput"
                                        accept="video/mp4,video/quicktime" required>
                                    <label class="custom-file-label text-truncate" for="videoInput">Bấm để chọn file
                                        video...</label>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <small class="text-muted"><i class="fas fa-video"></i> Ưu tiên video dọc (9:16).</small>
                                    <small id="fileSizeDisplay" class="text-primary font-weight-bold"></small>
                                </div>
                                @error('video')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar (Hiện khi đang upload) -->
                    <div id="progressContainer" class="card shadow mb-4 border-0 d-none bg-light">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="font-weight-bold text-primary"><i class="fas fa-sync fa-spin mr-2"></i>Đang xử
                                    lý dữ liệu...</span>
                                <span id="progressPercent" class="h4 mb-0 font-weight-bold text-primary">0%</span>
                            </div>
                            <div class="progress shadow-sm" style="height: 15px; border-radius: 10px;">
                                <div id="uploadProgressBar"
                                    class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                    role="progressbar" style="width: 0%"></div>
                            </div>
                            <p class="small text-danger mt-3 mb-0 font-italic text-center">
                                <strong>Lưu ý:</strong> Vui lòng không đóng trình duyệt hoặc chuyển trang lúc này.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Cột phải: Thumbnail & Cấu hình -->
                <div class="col-lg-4">
                    <div class="card shadow mb-4 border-0">
                        <div class="card-header py-3 bg-white">
                            <h6 class="m-0 font-weight-bold text-primary">Ảnh đại diện Video</h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3 position-relative preview-container">
                                <img id="thumbPreview" src="https://via.placeholder.com/600x800?text=Xem+trước+ảnh+bìa"
                                    class="img-fluid rounded shadow border"
                                    style="max-height: 350px; width: 100%; object-fit: cover;">
                            </div>
                            <div class="custom-file text-left">
                                <input type="file" name="thumbnail"
                                    class="custom-file-input @error('thumbnail') is-invalid @enderror" id="thumbInput"
                                    accept="image/*" required>
                                <label class="custom-file-label" for="thumbInput">Chọn ảnh bìa...</label>
                            </div>
                            @error('thumbnail')
                                <div class="text-danger small mt-1 text-left">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card shadow mb-4 border-0">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Thứ tự hiển thị</label>
                                <input type="number" name="sort_order" class="form-control"
                                    value="{{ old('sort_order', 0) }}">
                            </div>
                            <div class="custom-control custom-switch mt-4">
                                <input type="checkbox" name="is_active" class="custom-control-input" id="isActive"
                                    value="1" checked>
                                <label class="custom-control-label font-weight-bold text-dark" for="isActive">Công khai
                                    video ngay</label>
                            </div>
                            <hr>
                            <button type="submit" id="btnSubmit"
                                class="btn btn-primary btn-block py-3 font-weight-bold shadow border-0"
                                style="font-size: 1.1rem;">
                                <i class="fas fa-cloud-upload-alt mr-2"></i> BẮT ĐẦU TẢI LÊN
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            /* Customize Select2 Multiple "xịn" */
            .select2-container--default .select2-selection--multiple {
                border: 1px solid #d1d3e2;
                border-radius: 0.35rem;
                padding: 5px;
                min-height: 45px;
            }

            .select2-container--default.select2-container--focus .select2-selection--multiple {
                border-color: #bac8f3;
                box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: #4e73df;
                border: none;
                color: #fff;
                border-radius: 4px;
                padding: 2px 10px;
                margin-top: 5px;
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                color: #fff;
                margin-right: 5px;
                border-right: 1px solid rgba(255, 255, 255, 0.3);
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
                background-color: transparent;
                color: #f8f9fc;
            }

            .custom-file-label::after {
                content: "Duyệt file";
            }

            .preview-container::before {
                content: "\f03e";
                font-family: "Font Awesome 5 Free";
                font-weight: 900;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-size: 3rem;
                color: rgba(0, 0, 0, 0.05);
                z-index: 0;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {
                // Khởi tạo Select2 với Placeholder và hỗ trợ nhiều mục
                $('.select2').select2({
                    width: '100%',
                    placeholder: $(this).data('placeholder'),
                    allowClear: true,
                    closeOnSelect: false // Giữ menu mở để chọn được nhiều máy nhanh hơn
                });

                // Xử lý hiển thị kích thước file video khi chọn
                $('#videoInput').on('change', function() {
                    let file = this.files[0];
                    let fileName = file.name;
                    let fileSize = (file.size / 1024 / 1024).toFixed(2); // MB

                    $(this).next('.custom-file-label').html(fileName);
                    $('#fileSizeDisplay').html('<i class="fas fa-file-import mr-1"></i>' + fileSize + ' MB');

                    if (fileSize > 200) {
                        Swal.fire('Cảnh báo!', 'Dung lượng file vượt quá 200MB, vui lòng nén video.',
                            'warning');
                    }
                });

                // Preview Thumbnail
                $('#thumbInput').change(function() {
                    const file = this.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function(event) {
                            $('#thumbPreview').attr('src', event.target.result);
                        }
                        reader.readAsDataURL(file);
                        $(this).next('.custom-file-label').html(file.name);
                    }
                });

                // AJAX UPLOAD
                $('#uploadVideoForm').on('submit', function(e) {
                    e.preventDefault();

                    let formData = new FormData(this);
                    let btnSubmit = $('#btnSubmit');
                    let progressContainer = $('#progressContainer');
                    let progressBar = $('#uploadProgressBar');
                    let progressPercent = $('#progressPercent');

                    progressContainer.removeClass('d-none');
                    btnSubmit.prop('disabled', true).addClass('btn-secondary').removeClass('btn-primary')
                        .html('<i class="fas fa-circle-notch fa-spin mr-2"></i> ĐANG TẢI LÊN...');

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        xhr: function() {
                            let xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    let percentComplete = Math.round((evt.loaded / evt
                                        .total) * 100);
                                    progressBar.css('width', percentComplete + '%');
                                    progressPercent.html(percentComplete + '%');

                                    if (percentComplete === 100) {
                                        progressPercent.html('99% (Đang xử lý file...)');
                                    }
                                }
                            }, false);
                            return xhr;
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: 'Video review đã được lưu hệ thống.',
                                timer: 2500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ route('admin.videos.index') }}";
                            });
                        },
                        error: function(xhr) {
                            btnSubmit.prop('disabled', false).addClass('btn-primary').removeClass(
                                    'btn-secondary')
                                .html('<i class="fas fa-cloud-upload-alt mr-2"></i> THỬ LẠI NGAY');
                            progressContainer.addClass('d-none');

                            let message = 'Có lỗi xảy ra trong quá trình upload.';
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                message = Object.values(xhr.responseJSON.errors)[0][0];
                            }
                            Swal.fire('Lỗi!', message, 'error');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
