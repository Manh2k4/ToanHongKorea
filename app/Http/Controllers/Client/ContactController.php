<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function store(ContactRequest $request) 
{
    Contact::create($request->validated());
    
    return response()->json(['message' => 'Gửi yêu cầu thành công']);
}

// Lọc dữ liệu cực chuyên nghiệp
$contacts = Contact::byService(ContactService::WARRANTY_SUPPORT)->pending()->get();
}
