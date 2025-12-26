<?php

namespace App\Providers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        // Sử dụng View Composer để chia sẻ dữ liệu category cho toàn bộ các view
        // Nếu bạn chỉ muốn chia sẻ cho file header, hãy thay '*' thành 'layouts.header' (tên file blade của bạn)
        View::composer('*', function ($view) {
            // Lấy tất cả danh mục gốc (parent_id = null) kèm theo các danh mục con
            $allCategories = Category::active()
                ->ordered()
                ->whereNull('parent_id')
                ->with(['children' => function ($query) {
                    $query->active()->ordered()->with(['children' => function ($q) {
                        $q->active()->ordered();
                    }]);
                }])
                ->get();

            // Phân loại dữ liệu để dễ đổ vào giao diện của bạn
            $view->with('menuIphones', $allCategories->filter(fn($c) => str_contains(strtolower($c->slug), 'iphone')));
            $view->with('menuSamsungs', $allCategories->filter(fn($c) => str_contains(strtolower($c->slug), 'samsung')));
            $view->with('menuSims', $allCategories->where('slug', 'goi-cuoc')->first()); // Theo SQL cũ bạn đặt là 'goi-cuoc'
        });
    }
}
