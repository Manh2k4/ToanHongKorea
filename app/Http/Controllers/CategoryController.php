<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        // Đếm số điện thoại trong mỗi danh mục
        // Nếu bạn muốn hiển thị tổng số điện thoại trong danh mục,
        // cần thêm `withCount('phones')` vào query
        // $query->withCount('phones');

        // Xử lý tìm kiếm
        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }

        $categories = $query->latest()->paginate(10); // Phân trang và sắp xếp mới nhất

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Category::ordered()->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {

   // Lấy dữ liệu đã được validate từ Form Request
        $validatedData = $request->validated();


        // Tự động tạo slug từ name nếu slug không được nhập
        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }


        // Tạo mới category
        Category::create($validatedData);


        // Chuyển hướng về trang danh sách và gửi kèm một thông báo thành công
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Chuyên mục đã được tạo thành công.');


    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id, // Loại trừ chính nó khi check unique
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique' => 'Tên danh mục này đã tồn tại.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục và các sách liên quan đã được xóa vĩnh viễn!');
    }
}
