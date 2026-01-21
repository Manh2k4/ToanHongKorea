<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class ReviewVideo extends Model
{
    use HasFactory;

    // Xóa phone_id khỏi fillable
    protected $fillable = ['title', 'video_path', 'thumbnail_path', 'sort_order', 'is_active'];

    /**
     * Một Video có thể gắn với NHIỀU sản phẩm (Phones)
     */
    public function phones()
    {
        // phone_review_video là tên bảng trung gian chúng ta vừa tạo ở trên
        return $this->belongsToMany(Phone::class, 'phone_review_video');
    }

    // Accessor lấy URL video (Giữ nguyên)
    public function getVideoUrlAttribute()
    {
        return $this->video_path ? Storage::url($this->video_path) : null;
    }

    // Accessor lấy URL thumbnail (Giữ nguyên)
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_path ? Storage::url($this->thumbnail_path) : asset('images/default-video-thumb.jpg');
    }
}
