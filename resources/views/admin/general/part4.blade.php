<style>
    .stat-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        overflow: hidden;
        color: white;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important;
    }
    .card-gradient-1 { background: linear-gradient(45deg, #4e73df, #224abe); }
    .card-gradient-2 { background: linear-gradient(45deg, #1cc88a, #13855c); }
    .card-gradient-3 { background: linear-gradient(45deg, #f6c23e, #dda20a); }
    .card-gradient-4 { background: linear-gradient(45deg, #36b9cc, #258391); }
    .card-gradient-5 { background: linear-gradient(45deg, #6610f2, #4e08bc); }
    .card-gradient-6 { background: linear-gradient(45deg, #e74a3b, #be2617); }
    .card-gradient-7 { background: linear-gradient(45deg, #fd7e14, #e66a05); }
    .card-gradient-8 { background: linear-gradient(45deg, #5a5c69, #373840); }

    .detail-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        cursor: pointer;
        transition: 0.3s;
    }
    .detail-btn:hover { background: rgba(255, 255, 255, 0.4); }
    .collapse-content {
        background: rgba(0, 0, 0, 0.1);
        font-size: 0.85rem;
        padding: 10px;
        border-top: 1px solid rgba(255,255,255,0.1);
    }
</style>

<div class="row">
    <!-- Cột 1: Kho hàng (Variant) -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card card-gradient-1 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 text-xs font-weight-bold text-uppercase mb-1">Thiết bị trong kho</div>
                        <div class="h3 mb-0 font-weight-bold">{{ number_format($totalVariants) }} <small style="font-size:12px">mẫu</small></div>
                    </div>
                    <i class="fas fa-boxes fa-2x text-white-50"></i>
                </div>
                <div class="mt-3">
                    <button class="detail-btn" type="button" data-toggle="collapse" data-target="#detail1">
                        Xem chi tiết <i class="fas fa-chevron-down ml-1"></i>
                    </button>
                </div>
            </div>
            <div class="collapse collapse-content" id="detail1">
                <div>Tổng tồn kho: <strong>{{ number_format($totalStock) }}</strong> sản phẩm</div>
                <div>Trạng thái: Đang cập nhật...</div>
            </div>
        </div>
    </div>

    <!-- Cột 2: Gói cước -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card card-gradient-2 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 text-xs font-weight-bold text-uppercase mb-1">Gói cước hoạt động</div>
                        <div class="h3 mb-0 font-weight-bold">{{ $packagesCount }}</div>
                    </div>
                    <i class="fas fa-sim-card fa-2x text-white-50"></i>
                </div>
                <div class="mt-3">
                    <button class="detail-btn" type="button" data-toggle="collapse" data-target="#detail2">
                        Chi tiết nhà mạng <i class="fas fa-chevron-down ml-1"></i>
                    </button>
                </div>
            </div>
            <div class="collapse collapse-content" id="detail2">
                @php $carriers = ['SK' => 'sk', 'KT' => 'kt', 'LG' => 'lgu']; @endphp
                @foreach($carriers as $name => $code)
                    <div class="d-flex justify-content-between">
                        <span>{{ $name }}:</span> 
                        <strong>{{ \App\Models\Package::where('carrier', $code)->count() }}</strong>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Cột 3: Nhân sự & User -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card card-gradient-3 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 text-xs font-weight-bold text-uppercase mb-1">Nhân sự & Khách</div>
                        <div class="h4 mb-0 font-weight-bold">{{ $employeesCount }} NV / {{ $usersCount }} User</div>
                    </div>
                    <i class="fas fa-users fa-2x text-white-50"></i>
                </div>
                <div class="mt-3">
                    <button class="detail-btn" type="button" data-toggle="collapse" data-target="#detail3">
                        Trạng thái Online <i class="fas fa-chevron-down ml-1"></i>
                    </button>
                </div>
            </div>
            <div class="collapse collapse-content" id="detail3">
                <div>Đang Online: <strong>{{ $employees->count() }}</strong> nhân viên</div>
                <a href="{{ route('admin.accounts.index') }}" class="text-white border-bottom" style="font-size: 11px">Quản lý người dùng</a>
            </div>
        </div>
    </div>

    <!-- Cột 4: Lượt tương tác SP -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card card-gradient-4 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 text-xs font-weight-bold text-uppercase mb-1">Lượt xem sản phẩm</div>
                        <div class="h3 mb-0 font-weight-bold">{{ number_format($totalProductViews) }}</div>
                    </div>
                    <i class="fas fa-eye fa-2x text-white-50"></i>
                </div>
                <div class="mt-3">
                    <button class="detail-btn" type="button" data-toggle="collapse" data-target="#detail4">
                        Xem Top SP <i class="fas fa-chevron-down ml-1"></i>
                    </button>
                </div>
            </div>
            <div class="collapse collapse-content" id="detail4">
                @foreach($topPhones as $tp)
                    <div class="text-truncate" style="max-width: 180px;">• {{ $tp->name }} ({{ $tp->views_count }})</div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Cột 5: Đơn hàng & Doanh thu -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card card-gradient-5 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 text-xs font-weight-bold text-uppercase mb-1">Đơn hàng mới</div>
                        <div class="h3 mb-0 font-weight-bold">5</div>
                    </div>
                    <i class="fas fa-shopping-cart fa-2x text-white-50"></i>
                </div>
                <div class="mt-3">
                    <button class="detail-btn" type="button" data-toggle="collapse" data-target="#detail5">
                        Doanh thu <i class="fas fa-chevron-down ml-1"></i>
                    </button>
                </div>
            </div>
            <div class="collapse collapse-content" id="detail5">
                <div>Tổng doanh thu: <strong>{{ number_format($totalRevenue ?? 0) }} VNĐ</strong></div>
            </div>
        </div>
    </div>

    <!-- Cột 6: Truy cập Website -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card card-gradient-6 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 text-xs font-weight-bold text-uppercase mb-1">Truy cập Website</div>
                        <div class="h3 mb-0 font-weight-bold">{{ number_format($webVisits ?? 0) }}</div>
                    </div>
                    <i class="fas fa-globe fa-2x text-white-50"></i>
                </div>
                <div class="mt-3">
                    <button class="detail-btn" type="button" data-toggle="collapse" data-target="#detail6">
                        Thiết bị truy cập <i class="fas fa-chevron-down ml-1"></i>
                    </button>
                </div>
            </div>
            <div class="collapse collapse-content" id="detail6">
                <div>Mobile: 65% | Desktop: 35%</div>
            </div>
        </div>
    </div>

    <!-- Cột 7: Yêu thích -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card card-gradient-7 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 text-xs font-weight-bold text-uppercase mb-1">Lượt yêu thích SP</div>
                        <div class="h3 mb-0 font-weight-bold">{{ number_format($totalFavorites ?? 0) }}</div>
                    </div>
                    <i class="fas fa-heart fa-2x text-white-50"></i>
                </div>
                <div class="mt-3">
                    <button class="detail-btn" type="button" data-toggle="collapse" data-target="#detail7">
                        Tỉ lệ quan tâm <i class="fas fa-chevron-down ml-1"></i>
                    </button>
                </div>
            </div>
            <div class="collapse collapse-content" id="detail7">
                <div>Tăng 12% so với tháng trước</div>
            </div>
        </div>
    </div>

    <!-- Cột 8: Sắp hết hàng -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card card-gradient-8 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 text-xs font-weight-bold text-uppercase mb-1">Cần nhập kho</div>
                        <div class="h3 mb-0 font-weight-bold text-warning">{{ $outOfStockCount ?? 0 }} <small style="font-size:12px">mẫu</small></div>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-2x text-white-50"></i>
                </div>
                <div class="mt-3">
                    <button class="detail-btn" type="button" data-toggle="collapse" data-target="#detail8">
                        Xem danh sách <i class="fas fa-chevron-down ml-1"></i>
                    </button>
                </div>
            </div>
            <div class="collapse collapse-content" id="detail8">
                @foreach($lowStockPhones as $lp)
                   <div class="text-truncate" style="max-width: 180px;">• {{ $lp->name }} (Còn {{ $lp->variants_sum_stock }})</div>
                @endforeach
            </div>
        </div>
    </div>
</div>