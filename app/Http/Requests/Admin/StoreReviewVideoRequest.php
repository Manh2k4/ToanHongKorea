<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /**
         * Cách kiểm tra xem đây là Request tạo mới hay cập nhật "xịn" nhất:
         * Kiểm tra xem route hiện tại có tham số 'video' (ID của bản ghi) hay không.
         * Route::resource tạo route update có tên tham số trùng với tên resource số ít.
         */
        $videoId = $this->route('video');
        $isUpdate = !empty($videoId);

        return [
            'phone_ids' => 'required|array|min:1',
            'phone_ids.*' => 'exists:phones,id', // Từng ID trong mảng phải tồn tại

            'title' => 'required|string|max:255',

            'video' => [
                $isUpdate ? 'nullable' : 'required',
                'mimetypes:video/mp4,video/quicktime',
                'max:202400', // 200MB
            ],

            'thumbnail' => [
                $isUpdate ? 'nullable' : 'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:4048', // 4MB
            ],

            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi bằng tiếng Việt.
     */
    public function messages(): array
    {
        return [
            'phone_id.required' => 'Vui lòng chọn một sản phẩm để gắn video review.',
            'phone_ids.array' => 'Dữ liệu sản phẩm không hợp lệ.',
            'phone_id.exists' => 'Sản phẩm được chọn không tồn tại trong hệ thống.',

            'title.required' => 'Tiêu đề video không được để trống.',
            'title.string' => 'Tiêu đề phải là chuỗi ký tự.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',

            'video.required' => 'Vui lòng tải lên file video review.',
            'video.mimetypes' => 'Định dạng video không hỗ trợ (Chỉ chấp nhận .mp4 hoặc .mov).',
            'video.max' => 'Dung lượng video quá lớn, tối đa là 200MB.',

            'thumbnail.required' => 'Ảnh đại diện (Thumbnail) cho video là bắt buộc.',
            'thumbnail.image' => 'File tải lên phải là định dạng hình ảnh.',
            'thumbnail.mimes' => 'Ảnh đại diện chỉ chấp nhận các định dạng: jpeg, png, jpg, webp.',
            'thumbnail.max' => 'Dung lượng ảnh đại diện không được vượt quá 4MB.',

            'sort_order.integer' => 'Thứ tự hiển thị phải là một số nguyên.',
        ];
    }

    /**
     * Tùy chỉnh tên các thuộc tính (để báo lỗi gọn hơn nếu dùng mặc định)
     */
    public function attributes(): array
    {
        return [
            'phone_id' => 'Sản phẩm',
            'title' => 'Tiêu đề',
            'video' => 'Video review',
            'thumbnail' => 'Ảnh đại diện',
        ];
    }
}
