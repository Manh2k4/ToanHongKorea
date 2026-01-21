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
        Log::info('--- BẮT ĐẦU QUY TRÌNH STORE VIDEO ---');
        Log::info('Dữ liệu Request:', $request->except(['video', 'thumbnail']));

        DB::beginTransaction();
        $uploadedFiles = [];

        try {
            $data = $request->validated();
            $slug = Str::slug($data['title']);
            $phoneIds = $data['phone_ids'];
            unset($data['phone_ids']);

            // Kiểm tra thư mục đích có tồn tại/ghi được không
            if (!Storage::disk('public')->exists('videos/reviews')) {
                Log::warning('Thư mục videos/reviews chưa tồn tại, đang thử tạo...');
                Storage::disk('public')->makeDirectory('videos/reviews');
            }

            // 1. Xử lý Video
            if ($request->hasFile('video')) {
                $file = $request->file('video');
                Log::info('Phát hiện file Video:', [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize() . ' bytes',
                    'mime' => $file->getMimeType()
                ]);

                $videoName = $slug . '-' . time() . '.' . $file->extension();
                $path = $file->storeAs('videos/reviews', $videoName, 'public');

                if ($path) {
                    $data['video_path'] = $path;
                    $uploadedFiles[] = $path;
                    Log::info('Lưu video thành công vào path: ' . $path);
                } else {
                    throw new \Exception('Không thể lưu file video vào ổ cứng.');
                }
            }

            // 2. Xử lý Thumbnail
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                Log::info('Phát hiện file Thumbnail:', ['name' => $file->getClientOriginalName()]);

                $thumbName = $slug . '-thumb-' . time() . '.' . $file->extension();
                $data['thumbnail_path'] = $file->storeAs('videos/thumbnails', $thumbName, 'public');
                $uploadedFiles[] = $data['thumbnail_path'];
                Log::info('Lưu thumbnail thành công: ' . $data['thumbnail_path']);
            }

            // 3. Lưu DB
            $video = ReviewVideo::create($data);
            Log::info('Đã tạo bản ghi Video ID: ' . $video->id);

            $video->phones()->sync($phoneIds);
            Log::info('Đã sync IDs điện thoại:', $phoneIds);

            DB::commit();
            Log::info('--- KẾT THÚC STORE THÀNH CÔNG ---');

            return redirect()->route('admin.videos.index')->with('success', 'Đăng tải thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('LỖI TRONG QUÁ TRÌNH STORE: ' . $e->getMessage());
            Log::error('Stack trace:', ['trace' => $e->getTraceAsString()]);

            foreach ($uploadedFiles as $file) {
                Storage::disk('public')->delete($file);
                Log::info('Đã dọn dẹp file lỗi: ' . $file);
            }

            return back()->withInput()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
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
        Log::info('--- BẮT ĐẦU CẬP NHẬT VIDEO ID: ' . $video->id . ' ---');

        DB::beginTransaction();
        $oldFiles = [];
        $newUploadedFiles = [];

        try {
            $data = $request->validated();
            $slug = Str::slug($data['title']);
            $phoneIds = $data['phone_ids'];
            unset($data['phone_ids']);

            if ($request->hasFile('video')) {
                Log::info('Cập nhật Video mới...');
                $oldFiles[] = $video->video_path;
                $videoName = $slug . '-' . time() . '.' . $request->video->extension();
                $data['video_path'] = $request->file('video')->storeAs('videos/reviews', $videoName, 'public');
                $newUploadedFiles[] = $data['video_path'];
            }

            if ($request->hasFile('thumbnail')) {
                Log::info('Cập nhật Thumbnail mới...');
                $oldFiles[] = $video->thumbnail_path;
                $thumbName = $slug . '-thumb-' . time() . '.' . $request->thumbnail->extension();
                $data['thumbnail_path'] = $request->file('thumbnail')->storeAs('videos/thumbnails', $thumbName, 'public');
                $newUploadedFiles[] = $data['thumbnail_path'];
            }

            $video->update($data);
            $video->phones()->sync($phoneIds);

            DB::commit();

            if (!empty($oldFiles)) {
                Storage::disk('public')->delete($oldFiles);
                Log::info('Đã xóa các file cũ để giải phóng SSD:', $oldFiles);
            }

            Log::info('--- CẬP NHẬT THÀNH CÔNG ---');
            return redirect()->route('admin.videos.index')->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('LỖI CẬP NHẬT: ' . $e->getMessage());

            // Xóa file mới up nếu DB lỗi
            foreach ($newUploadedFiles as $file) {
                Storage::disk('public')->delete($file);
            }

            return back()->withInput()->with('error', 'Thất bại: ' . $e->getMessage());
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
