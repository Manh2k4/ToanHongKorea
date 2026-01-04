<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class DetectDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $agent = new Agent();

        // 1. Khởi tạo các biến mặc định
        $isMobile = false;
        $isIphone = false;
        $isAndroid = false;

        if (!$request->is('admin*')) {
            // 2. Kiểm tra iPhone / Android cụ thể
            // isIphone() và isAndroidOS() là các hàm có sẵn của thư viện Jenssegers\Agent
            $isIphone = $agent->is('iPhone');
            $isAndroid = $agent->isAndroidOS();

            // Kiểm tra xem là Mobile thật hoặc đang dùng mode dev=mobile
            if (($agent->isMobile() && !$agent->isTablet()) || $request->dev == 'mobile') {
                $isMobile = true;
                view()->getFinder()->prependLocation(resource_path('views/client/mobile'));
            } else {
                view()->getFinder()->prependLocation(resource_path('views/client/desktop'));
            }
        }

        // 3. CHIA SẺ VỚI TẤT CẢ FILE BLADE
        view()->share('isMobile', $isMobile);
        view()->share('isIphone', $isIphone);
        view()->share('isAndroid', $isAndroid);

        // Bạn cũng có thể chia sẻ tên hệ điều hành nếu muốn dùng linh hoạt hơn
        view()->share('platform', $agent->platform()); // Trả về: iOS, Android, Windows, OS X...

        return $next($request);
    }
}
