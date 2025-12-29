<div class="container-fluid">
    <div class="row">
        <!-- Cột bên trái: Ảnh chính và thông tin cơ bản -->
        <div class="col-md-4 text-center border-right">
            @if ($phone->main_image)
                <img src="{{ Storage::url($phone->main_image) }}" class="img-fluid rounded shadow-sm mb-3"
                    alt="{{ $phone->name }}" style="max-height: 250px; object-fit: contain;">
            @else
                <img src="https://via.placeholder.com/250x250?text=No+Image" class="img-fluid rounded mb-3" alt="No Image">
            @endif
            <h5 class="font-weight-bold text-primary">{{ $phone->name }}</h5>
            <span class="badge badge-info p-2 mb-3">{{ $phone->category->name ?? 'Không có danh mục' }}</span>
            
            <div class="text-left mt-3">
                <p><strong>Mô tả ngắn:</strong><br> <span class="text-muted">{{ $phone->short_description ?? 'N/A' }}</span></p>
            </div>
        </div>

        <!-- Cột bên phải: Biến thể và Thư viện ảnh -->
        <div class="col-md-8">
            <h6 class="font-weight-bold"><i class="fas fa-list"></i> Danh sách biến thể:</h6>
            @if ($phone->variants->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-sm" style="font-size: 0.85rem;">
                        <thead class="bg-primary text-white text-center">
                            <tr>
                                <th>Ảnh</th>
                                <th>Tình trạng</th>
                                <th>Cấu hình (Specs)</th>
                                <th>Giá & Kho</th>
                                <th>Thông tin máy cũ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($phone->variants as $variant)
                                <tr>
                                    <!-- Ảnh biến thể -->
                                    <td class="text-center">
                                        @if ($variant->image_path)
                                            <img src="{{ Storage::url($variant->image_path) }}" width="50" class="img-thumbnail">
                                        @else
                                            <small class="text-muted">No Image</small>
                                        @endif
                                    </td>

                                    <!-- Tình trạng -->
                                    <td class="text-center">
                                        @if($variant->condition == 'used')
                                            <span class="badge badge-warning">Máy cũ</span>
                                        @else
                                            <span class="badge badge-success">Máy mới</span>
                                        @endif
                                        <div class="mt-1 small text-muted">SKU: {{ $variant->sku ?? 'N/A' }}</div>
                                    </td>

                                    <!-- Cấu hình chung -->
                                    <td>
                                        <div><strong>{{ $variant->size->name ?? '' }} | {{ $variant->color->name ?? '' }}</strong></div>
                                        <div class="small">
                                            <i class="fas fa-microchip"></i> RAM: {{ $variant->general_specs['ram'] ?? 'N/A' }} <br>
                                            <i class="fas fa-hdd"></i> Bộ nhớ: {{ $variant->general_specs['storage'] ?? 'N/A' }} <br>
                                            <i class="fas fa-mobile-alt"></i> Màn hình: {{ $variant->general_specs['screen_size'] ?? 'N/A' }}
                                        </div>
                                    </td>

                                    <!-- Giá & Kho -->
                                    <td>
                                        <div class="text-danger font-weight-bold">{{ number_format($variant->price, 0, ',', '.') }} w</div>
                                        <div class="small text-muted">Kho: {{ $variant->stock }}</div>
                                        @if($variant->is_default) <span class="badge badge-dark">Mặc định</span> @endif
                                    </td>

                                    @if($variant->condition == 'used')
                                    <!-- Thông tin máy cũ -->
                                    <td class="bg-light">
                                        @if($variant->condition == 'used' && $variant->used_details)
                                            <div class="small">
                                                <div><i class="fas fa-battery-three-quarters"></i> Pin: {{ $variant->used_details['battery_health'] ?? 'N/A' }}%</div>
                                                <div><i class="fas fa-plug"></i> Sạc: {{ $variant->used_details['charging_cycles'] ?? 'N/A' }} lần</div>
                                                <div class="text-italic border-top mt-1" style="font-size: 0.75rem;">
                                                    {{ $variant->used_details['description'] ?? '' }}
                                                </div>
                                            </div>
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    @else
                                    <td class="bg-light text-center">Không có thông tin</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">Không có biến thể nào.</p>
            @endif

            <hr>

            <!-- Thư viện hình ảnh phụ -->
            <h6 class="font-weight-bold"><i class="fas fa-images"></i> Thư viện ảnh phụ:</h6>
            @if ($phone->images->isNotEmpty())
                <div class="row no-gutters">
                    @foreach ($phone->images as $image)
                        <div class="col-md-3 p-1">
                            <div class="border rounded p-1">
                                <img src="{{ Storage::url($image->image_path) }}" class="img-fluid rounded"
                                    style="height: 150px; width: 100%; object-fit: cover;" alt="Gallery">
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="small text-muted italic">Sản phẩm này không có ảnh phụ.</p>
            @endif

        </div>
    </div>
</div>