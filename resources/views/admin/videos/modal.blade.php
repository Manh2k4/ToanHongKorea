    {{-- Phần Modal Xem thử Video --}}
    <div class="modal fade" id="videoPreviewModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg bg-dark text-white">
                <div class="modal-header border-0 pb-0">
                    <div class="modal-title" id="videoModalLabel">
                        <h5 class="text-white mb-0" id="previewTitle"></h5>
                        <small class="text-info" id="previewPhone"></small>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"
                        style="outline: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3">
                    <div class="embed-responsive embed-responsive-16by9 rounded shadow bg-black">
                        <video id="mainVideoPlayer" controls controlsList="nodownload" class="embed-responsive-item"
                            autoplay>
                            <source src="" type="video/mp4">
                        </video>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Đóng cửa sổ</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        #videoPreviewModal .modal-content {
            border-radius: 15px;
        }

        #mainVideoPlayer {
            background: #000;
        }

        .bg-black {
            background-color: #000;
        }
    </style>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                // Xem thử Video
                $('.view-video-btn').click(function() {
                    const videoUrl = $(this).data('url');
                    const title = $(this).data('title');
                    const phone = $(this).data('phone');

                    $('#previewTitle').text(title);
                    $('#previewPhone').text('Liên quan: ' + phone);

                    const videoPlayer = document.getElementById('mainVideoPlayer');
                    videoPlayer.src = videoUrl;
                    $('#videoPreviewModal').modal('show');
                    videoPlayer.load();
                    videoPlayer.play();
                });

                // Tắt video khi đóng Modal
                $('#videoPreviewModal').on('hidden.bs.modal', function() {
                    const videoPlayer = document.getElementById('mainVideoPlayer');
                    videoPlayer.pause();
                    videoPlayer.src = "";
                });

                // Bật/tắt trạng thái hiển thị
                $('.toggle-status').change(function() {
                    let id = $(this).data('id');
                    $.post(`{{ url('admin/videos') }}/${id}/toggle-status`, {
                        _token: '{{ csrf_token() }}'
                    }, function(res) {
                        if (res.success) {
                            Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                                .fire({
                                    icon: 'success',
                                    title: 'Đã cập nhật trạng thái'
                                });
                        }
                    });
                });

                // Xóa video
                $('.delete-video').click(function() {
                    let id = $(this).data('id');
                    let row = $(this).closest('tr');

                    Swal.fire({
                        title: 'Xác nhận xóa?',
                        text: "Video này sẽ biến mất khỏi tất cả sản phẩm liên quan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e74a3b',
                        confirmButtonText: 'Đồng ý xóa'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `{{ url('admin/videos') }}/${id}`,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(res) {
                                    if (res.success) {
                                        row.fadeOut(500, function() {
                                            $(this).remove();
                                        });
                                        Swal.fire('Đã xóa!', res.message, 'success');
                                    }
                                }
                            });
                        }
                    })
                });
            });
        </script>
    @endpush
