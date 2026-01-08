@extends('client.desktop.layouts.app')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">Sản phẩm bạn đã thích ({{ $items->count() }})</h3>
    
    @if($items->isEmpty())
        <div class="text-center">
            <p>Chưa có sản phẩm nào trong danh sách.</p>
            <a href="/" class="btn btn-primary">Tiếp tục xem sản phẩm</a>
        </div>
    @else
        <div class="row">
            @foreach($items as $item)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="text-danger fw-bold">{{ number_format($item->price) }}đ</p>
                            
                            @php
                                // Tạo link Messenger với nội dung sẵn
                                $message = "Chào Admin, mình quan tâm đến sản phẩm: " . $item->name;
                                $fbLink = "https://m.me/YOUR_PAGE_ID?text=" . urlencode($message);
                            @endphp
                            
                            <div class="d-grid gap-2">
                                <a href="{{ $fbLink }}" target="_blank" class="btn btn-info text-white">
                                    <i class="fab fa-facebook-messenger"></i> Nhận tư vấn ngay
                                </a>
                                <button class="btn btn-outline-danger btn-sm btn-favorite" data-id="{{ $item->id }}" data-type="{{ isset($item->network) ? 'package' : 'phone' }}">
                                    Xóa khỏi yêu thích
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection