<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        // Lấy danh sách màu kèm theo số lượng biến thể đang sử dụng màu đó
        $colors = Color::withCount('variants')->latest()->paginate(10);
        return view('admin.colors.index', compact('colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:colors,name|max:50',
            'hex_code' => 'required|max:7',
        ], [
            'name.unique' => 'Tên màu này đã tồn tại.',
            'hex_code.required' => 'Vui lòng chọn mã màu.'
        ]);

        Color::create($request->all());

        return redirect()->back()->with('success', 'Thêm màu sắc thành công!');
    }

    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => 'required|max:50|unique:colors,name,' . $color->id,
            'hex_code' => 'required|max:7',
        ]);

        $color->update($request->all());

        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }

    public function destroy(Color $color)
    {
        if ($color->variants()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa màu đang có sản phẩm sử dụng!');
        }
        $color->delete();
        return redirect()->back()->with('success', 'Xóa màu thành công!');
    }
}
