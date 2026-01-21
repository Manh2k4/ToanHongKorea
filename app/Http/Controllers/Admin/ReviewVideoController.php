<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReviewVideo;
use App\Models\Phone;
use App\Http\Requests\Admin\StoreReviewVideoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Storage, DB, Log};
use Illuminate\Support\Str;

class ReviewVideoController extends Controller
{
    public function index(Request $request)
    {
        // Load quan hệ 'phones' (số nhiều)
        $videos = ReviewVideo::with('phones')
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'LIKE', "%$search%");
            })
            ->orderBy('sort_order', 'asc')
            ->latest()
            ->paginate(10);

        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $phones = Phone::active()->select('id', 'name')->get();
        return view('admin.videos.create', compact('phones'));
    }

    public function store(StoreReviewVideoRequest $request)
    {
        DB::beginTransaction();
        $uploadedFiles = [];

        try {
            $data = $request->validated();
            $slug = Str::slug($data['title']);

            // Lấy danh sách ID điện thoại ra và xóa khỏi mảng data để create video
            $phoneIds = $data['phone_ids'];
            unset($data['phone_ids']);

            if ($request->hasFile('video')) {
                $videoName = $slug . '-' . time() . '.' . $request->video->extension();
                $data['video_path'] = $request->file('video')->storeAs('videos/reviews', $videoName, 'public');
                $uploadedFiles[] = $data['video_path'];
            }

            if ($request->hasFile('thumbnail')) {
                $thumbName = $slug . '-thumb-' . time() . '.' . $request->thumbnail->extension();
                $data['thumbnail_path'] = $request->file('thumbnail')->storeAs('videos/thumbnails', $thumbName, 'public');
                $uploadedFiles[] = $data['thumbnail_path'];
            }

            // 1. Lưu thông tin video
            $video = ReviewVideo::create($data);

            // 2. Lưu quan hệ nhiều-nhiều vào bảng trung gian
            $video->phones()->sync($phoneIds);

            DB::commit();
            return redirect()->route('admin.videos.index')->with('success', 'Video review đã được đăng tải thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            foreach ($uploadedFiles as $file) {
                Storage::disk('public')->delete($file);
            }
            Log::error("Lỗi Store Video Review: " . $e->getMessage());
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit(ReviewVideo $video)
    {
        // Load sẵn các ID đã chọn để hiển thị ở view
        $selectedPhoneIds = $video->phones()->pluck('phones.id')->toArray();
        $phones = Phone::active()->select('id', 'name')->get();

        return view('admin.videos.edit', compact('video', 'phones', 'selectedPhoneIds'));
    }

    public function update(StoreReviewVideoRequest $request, ReviewVideo $video)
    {
        DB::beginTransaction();
        $oldFiles = [];

        try {
            $data = $request->validated();
            $slug = Str::slug($data['title']);

            // Tách phone_ids ra
            $phoneIds = $data['phone_ids'];
            unset($data['phone_ids']);

            if ($request->hasFile('video')) {
                $oldFiles[] = $video->video_path;
                $videoName = $slug . '-' . time() . '.' . $request->video->extension();
                $data['video_path'] = $request->file('video')->storeAs('videos/reviews', $videoName, 'public');
            }

            if ($request->hasFile('thumbnail')) {
                $oldFiles[] = $video->thumbnail_path;
                $thumbName = $slug . '-thumb-' . time() . '.' . $request->thumbnail->extension();
                $data['thumbnail_path'] = $request->file('thumbnail')->storeAs('videos/thumbnails', $thumbName, 'public');
            }

            // 1. Cập nhật thông tin video
            $video->update($data);

            // 2. Cập nhật lại danh sách sản phẩm liên kết (xóa cũ, thêm mới tự động)
            $video->phones()->sync($phoneIds);

            DB::commit();
            if (!empty($oldFiles)) {
                Storage::disk('public')->delete($oldFiles);
            }

            return redirect()->route('admin.videos.index')->with('success', 'Cập nhật video thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi Update Video Review: " . $e->getMessage());
            return back()->withInput()->with('error', 'Cập nhật thất bại!');
        }
    }

    public function destroy(ReviewVideo $video)
    {
        try {
            $filesToDelete = [$video->video_path, $video->thumbnail_path];

            // Khi xóa video, Laravel sẽ tự xóa các bản ghi trong bảng trung gian nhờ onDelete('cascade') trong migration
            $video->delete();

            Storage::disk('public')->delete($filesToDelete);

            return response()->json(['success' => true, 'message' => 'Đã xóa video.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function toggleStatus($id)
    {
        $video = ReviewVideo::findOrFail($id);
        $video->is_active = !$video->is_active;
        $video->save();
        return response()->json(['success' => true]);
    }
}
