<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
     // 1. Chính sách bảo mật
    public function privacy()
    {
        return view('pages.privacy');
    }

    // 2. Điều khoản dịch vụ
    public function terms()
    {
        return view('pages.terms');
    }

    // 3. Hướng dẫn đăng ký sim
    public function simGuide()
    {
        return view('pages.sim-guide');
    }

    // 4. Hỗ trợ dịch vụ (Nạp tiền, Data, Trả trước)
    public function support()
    {
        return view('pages.support');
    }

    // 5. Câu hỏi thường gặp
    public function faqs()
    {
        return view('pages.faqs');
    }

    // 6. Quy định bảo hành & Đổi trả
    public function warranty()
    {
        return view('pages.warranty');
    }

    // 7. Chính sách giao hàng
    public function shipping()
    {
        return view('pages.shipping');
    }
}