@extends('admin.layouts')

@section('title', 'Chỉnh sửa Video Review')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa Video: <span class="text-primary">{{ $video->title }}</span></h1>
            <a href="{{ route('admin.videos.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm"></i> Quay lại danh sách
            </a>
        </div>

        <form action="{{ route('admin.videos.update', $video->id) }}" method="POST" enctype="multipart/form-data"
            id="updateVideoForm">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Cột trái: Thông tin chính -->
                <div class="col-lg-7">
                    <div class="card shadow mb-4 border-0">
                        <div class="card-header py-3 bg-white">
                            <h6 class="m-0 font-weight-bold text-primary">Thông tin Video & Sản phẩm liên kết</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-dark">Sản phẩm liên quan <span
                                        class="text-danger">*</span></label>
                                {{-- QUAN TRỌNG: Multiple Select2 nạp dữ liệu từ $selectedPhoneIds --}}
                                <select name="phone_ids[]"
                                    class="form-control select2 @error('phone_ids') is-invalid @enderror"
                                    multiple="multiple" data-placeholder="Tìm và thêm sản phẩm..." required>
                                    @foreach ($phones as $phone)
                                        <option value="{{ $phone->id }}"
                                            {{ in_array($phone->id, old('phone_ids', $selectedPhoneIds)) ? 'selected' : '' }}>
                                            {{ $phone->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('phone_ids')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-dark">Tiêu đề Video</label>
                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $video->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label class="font-weight-bold text-warning">
                                    <i class="fas fa-exclamation-triangle"></i> Thay đổi file Video mới
                                </label>
                                <div class="custom-file shadow-sm">
                                    <input type="file" name="video" class="custom-file-input" id="videoInput"
                                        accept="video/mp4,video/quicktime">
                                    <label class="custom-file-label text-truncate" for="videoInput">Để trống nếu muốn giữ
                                        video cũ...</label>
                                </div>
                                <small class="text-muted mt-2 d-block">* Hệ thống sẽ tự động xóa video cũ trên SSD nếu bạn
                                    tải file mới lên.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar (Hiện khi upload video mới) -->
                    <div id="progressContainer" class="card shadow mb-4 border-0 d-none bg-light">
                        <div class="card-body py-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="font-weight-bold text-primary"><i class="fas fa-sync fa-spin mr-2"></i>Đang cập
                                    nhật dữ liệu...</span>
                                <span id="progressPercent" class="h4 mb-0 font-weight-bold text-primary">0%</span>
                            </div>
                            <div class="progress shadow-sm" style="height: 12px; border-radius: 10px;">
                                <div id="uploadProgressBar"
                                    class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                                    style="width: 0%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Player xem Video hiện tại -->
                    <div class="card shadow mb-4 border-0">
                        <div class="card-header py-3 bg-white">
                            <h6 class="m-0 font-weight-bold text-primary">Xem lại Video đang hiển thị</h6>
                        </div>
                        <div class="card-body p-2 bg-dark rounded-bottom text-center">
                            <video width="100%" style="max-height: 450px" controls
                                class="rounded shadow border border-secondary">
                                <source src="{{ $video->video_url }}" type="video/mp4">
                                Trình duyệt không hỗ trợ player.
                            </video>
                        </div>
                    </div>
                </div>

                <!-- Cột phải: Thumbnail & Cấu hình -->
                <div class="col-lg-5">
                    <div class="card shadow mb-4 border-0">
                        <div class="card-header py-3 bg-white">
                            <h6 class="m-0 font-weight-bold text-primary">Ảnh bìa Video (Thumbnail)</h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3 position-relative">
                                <img id="thumbPreview" src="{{ $video->thumbnail_url }}"
                                    class="img-fluid rounded shadow border"
                                    style="max-height: 380px; width: 100%; object-fit: cover;">
                            </div>
                            <div class="custom-file text-left">
                                <input type="file" name="thumbnail" class="custom-file-input" id="thumbInput"
                                    accept="image/*">
                                <label class="custom-file-label" for="thumbInput">Thay đổi ảnh bìa mới...</label>
                            </div>
                            <small class="text-info d-block mt-2 font-italic">* Ảnh hiện tại sẽ được thay thế sau khi nhấn
                                cập nhật.</small>
                        </div>
                    </div>

                    <div class="card shadow mb-4 border-0">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="font-weight-bold">Thứ tự ưu tiên</label>
                                <input type="number" name="sort_order" class="form-control"
                                    value="{{ $video->sort_order }}">
                            </div>
                            <div class="custom-control custom-switch mt-4">
                                <input type="checkbox" name="is_active" class="custom-control-input" id="isActive"
                                    value="1" {{ $video->is_active ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold" for="isActive">Kích hoạt hiển
                                    thị</label>
                            </div>
                            <hr>
                            <button type="submit" id="btnSubmit"
                                class="btn btn-warning btn-block py-3 font-weight-bold shadow-sm text-dark border-0">
                                <i class="fas fa-save mr-2"></i> LƯU THAY ĐỔI NGAY
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
            /* Custom Select2 Multiple */
            .select2-container--default .select2-selection--multiple {
                border: 1px solid #d1d3e2;
                border-radius: 0.35rem;
                padding: 5px;
                min-height: 45px;
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
                content: "Duyệt";
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {
                // Khởi tạo Select2 cho Multiple
                $('.select2').select2({
                    width: '100%',
                    allowClear: true,
                    closeOnSelect: false
                });

                // Hiển thị tên file khi chọn
                $('.custom-file-input').on('change', function() {
                    let fileName = $(this).val().split('\\').pop();
                    $(this).next('.custom-file-label').addClass("selected").html(fileName);
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
                    }
                });

                // XỬ LÝ UPDATE BẰNG AJAX + PROGRESS BAR
                $('#updateVideoForm').on('submit', function(e) {
                    e.preventDefault();

                    let formData = new FormData(this);
                    let btnSubmit = $('#btnSubmit');
                    let progressContainer = $('#progressContainer');
                    let progressBar = $('#uploadProgressBar');
                    let progressPercent = $('#progressPercent');

                    // Hiển thị progress bar nếu có upload file video hoặc ảnh bìa
                    if ($('#videoInput')[0].files.length > 0 || $('#thumbInput')[0].files.length > 0) {
                        progressContainer.removeClass('d-none');
                    }

                    btnSubmit.prop('disabled', true).html(
                        '<i class="fas fa-circle-notch fa-spin mr-2"></i> ĐANG LƯU...');

                    $.ajax({
                        // Fake PUT bằng cách thêm _method vào URL hoặc FormData
                        url: $(this).attr('action') + '?_method=PUT',
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
                                }
                            }, false);
                            return xhr;
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: 'Video review đã được cập nhật.',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ route('admin.videos.index') }}";
                            });
                        },
                        error: function(xhr) {
                            btnSubmit.prop('disabled', false).html(
                                '<i class="fas fa-save mr-2"></i> CẬP NHẬT LẠI');
                            progressContainer.addClass('d-none');
                            let msg = xhr.responseJSON ? (xhr.responseJSON.message || Object.values(
                                xhr.responseJSON.errors)[0][0]) : 'Lỗi không xác định';
                            Swal.fire('Lỗi!', msg, 'error');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
