<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhoneClientController extends Controller
{
    public function listByCategory(Request $request, $slug)
    {
        // 1. Tìm danh mục hiện tại
        $currentCategory = Category::where('slug', $slug)
            ->active()
            ->with('children')
            ->firstOrFail();

        $categoryIds = $currentCategory->getAllChildIds();

        // 2. Khởi tạo Query lấy Phone
        $query = Phone::whereIn('phones.categories_id', $categoryIds)
            ->where('phones.is_active', true)
            ->join('variants', 'phones.id', '=', 'variants.phone_id')
            ->where('variants.status', 'còn_hàng')
            // Tính toán các giá trị ảo để lọc/sắp xếp
            ->select(
                'phones.*',
                DB::raw('MIN(variants.price) as min_price'),
                DB::raw('SUM(variants.view) as total_views')
            )
            ->groupBy(
                'phones.id',
                'phones.categories_id',
                'phones.name',
                'phones.slug',
                'phones.short_description',
                'phones.is_active',
                'phones.main_image',
                'phones.created_at',
                'phones.updated_at',
                'phones.deleted_at'
            );

        // 3. Xử lý BỘ LỌC (Filter)
        // Lọc theo khoảng giá (nếu có)
        if ($request->has('price_range')) {
            switch ($request->price_range) {
                case 'under_500':
                    $query->having('min_price', '<', 500000);
                    break;
                case '500_1000':
                    $query->havingBetween('min_price', [500000, 1000000]);
                    break;
                case 'over_1000':
                    $query->having('min_price', '>', 1000000);
                    break;
            }
        }

        // 4. Xử lý SẮP XẾP (Sorting)
        $sort = $request->get('sort', 'latest'); // Mặc định là mới nhất
        switch ($sort) {
            case 'latest':
                $query->orderBy('phones.created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('phones.created_at', 'asc');
                break;
            case 'price_asc':
                $query->orderBy('min_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('min_price', 'desc');
                break;
            case 'popular':
                $query->orderBy('total_views', 'desc');
                break;
        }

        // 5. Thực thi và Phân trang
        $iphones = $query->with(['category', 'variants'])
            ->paginate(100)
            ->withQueryString(); // Quan trọng: Giữ lại tham số trên URL khi chuyển trang

        $categories_iphone = $currentCategory->children()->active()->ordered()->get();

        return view('phones.iphones.iphone-list', compact('iphones', 'currentCategory', 'categories_iphone'));
    }
}
