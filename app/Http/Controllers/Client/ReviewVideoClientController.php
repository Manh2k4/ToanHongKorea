<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ReviewVideo;
use Illuminate\Http\Request;

class ReviewVideoClientController extends Controller
{
    /**
     * Lấy dữ liệu video cho trang chủ
     */
    public function index()
    {
        $videos = ReviewVideo::with(['phones' => function ($query) {
            $query->with('variants'); // Lấy thêm variant để hiện giá nếu cần
        }])
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->take(8) // Lấy khoảng 8 video mới nhất
            ->get();

        // Thường trang chủ sẽ được gọi từ một HomeController chung
        // Bạn có thể dùng View Share hoặc trả trực tiếp về view home
        return view('client.desktop.home.index', compact('videos'));
    }
}
