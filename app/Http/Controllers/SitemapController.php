<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Category; // Đảm bảo bạn đã tạo Model này
use App\Models\Phone;    // Đảm bảo bạn đã tạo Model này
use App\Models\Package;  // Đảm bảo bạn đã tạo Model này

class SitemapController extends Controller
{
    public function index()
    {
        // Khởi tạo sitemap
        $sitemap = Sitemap::create();

        // 1. Thêm các trang tĩnh (Trang chủ, liên hệ, chính sách...)
        $sitemap->add(Url::create('/')
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        $sitemap->add(Url::create('/lien-he')->setPriority(0.7));
        $sitemap->add(Url::create('/pages/chinh-sach-bao-mat')->setPriority(0.3));
        $sitemap->add(Url::create('/pages/dieu-khoan-su-dung')->setPriority(0.3));

        // 2. Thêm các Danh mục (Categories) - Route: /{slug}
        $categories = Category::where('is_active', 1)->get();
        foreach ($categories as $category) {
            $sitemap->add(Url::create("/{$category->slug}")
                ->setLastModificationDate($category->updated_at)
                ->setPriority(0.8));
        }

        // 3. Thêm các Điện thoại (Phones) - Route: /phone/{slug}
        $phones = Phone::where('is_active', 1)->get();
        foreach ($phones as $phone) {
            $sitemap->add(Url::create("/phone/{$phone->slug}")
                ->setLastModificationDate($phone->updated_at)
                ->setPriority(0.9));
        }

        // 4. Thêm các Gói cước (Packages) - Route: /chi-tiet-goi/{slug}
        $packages = Package::all(); // Hoặc thêm điều kiện is_active nếu có
        foreach ($packages as $package) {
            $sitemap->add(Url::create("/chi-tiet-goi/{slug}") // Thay {slug} bằng biến thực tế
                ->setPriority(0.8));
        }

        // Trả về file XML cho trình duyệt
        return $sitemap->toResponse(request());
    }
}
