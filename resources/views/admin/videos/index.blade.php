@extends('admin.layouts')

@section('title', 'Kho Video Review')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kho Video Review</h1>
            <div>
                <a href="{{ route('admin.videos.create') }}" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Thêm video mới
                </a>
            </div>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4 border-0">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách Video Review Sản phẩm</h6>
                <div class="dropdown no-arrow">
                    <form action="{{ route('admin.videos.index') }}" method="GET"
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control bg-light border-0 small"
                                placeholder="Tìm tên video..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-light text-uppercase small font-weight-bold">
                            <tr>
                                <th class="pl-4">STT</th>
                                <th>Thumbnail</th>
                                <th>Tiêu đề & Sản phẩm liên kết</th>
                                <th>Thứ tự</th>
                                <th>Hiển thị</th>
                                <th class="text-right pr-4">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($videos as $video)
                                <tr>
                                    <td class="pl-4">
                                        #{{ ($videos->currentPage() - 1) * $videos->perPage() + $loop->iteration }}</td>
                                    <td>
                                        <div class="position-relative" style="width: 80px; height: 110px;">
                                            <img src="{{ $video->thumbnail_url }}" class="rounded shadow-sm w-100 h-100"
                                                style="object-fit: cover;">
                                            <div class="position-absolute"
                                                style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                <i class="fas fa-play-circle text-white fa-lg shadow"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold text-dark mb-1">{{ $video->title }}</div>
                                        <div class="d-flex flex-wrap" style="gap: 4px;">
                                            @foreach ($video->phones as $phone)
                                                <span class="badge badge-info border-0 font-weight-normal px-2 py-1"
                                                    style="font-size: 11px;">
                                                    <i class="fas fa-tag fa-xs mr-1"></i>{{ $phone->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-light border">{{ $video->sort_order }}</span>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input toggle-status"
                                                id="status_{{ $video->id }}" data-id="{{ $video->id }}"
                                                {{ $video->is_active ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="status_{{ $video->id }}"></label>
                                        </div>
                                    </td>
                                    <td class="text-right pr-4">
                                        <div class="btn-group shadow-sm">
                                            <button class="btn btn-sm btn-outline-info view-video-btn"
                                                data-url="{{ $video->video_url }}" data-title="{{ $video->title }}"
                                                {{-- Gộp tên sản phẩm thành chuỗi để hiện ở Modal --}}
                                                data-phone="{{ $video->phones->pluck('name')->implode(', ') }}"
                                                title="Xem thử">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="{{ route('admin.videos.edit', $video->id) }}"
                                                class="btn btn-sm btn-outline-warning" title="Chỉnh sửa"><i
                                                    class="fas fa-edit"></i></a>
                                            <button class="btn btn-sm btn-outline-danger delete-video"
                                                data-id="{{ $video->id }}" title="Xóa"><i
                                                    class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="100"
                                            class="mb-3 opacity-50">
                                        <p class="text-muted">Chưa có video review nào. Hãy thêm mới ngay!</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($videos->hasPages())
                <div class="card-footer bg-white border-0">
                    {{ $videos->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>

@endsection
@include('admin.videos.modal')
