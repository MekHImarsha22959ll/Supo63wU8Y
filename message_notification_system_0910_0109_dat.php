<?php
// 代码生成时间: 2025-09-10 01:09:28
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageNotificationController;

// 定义消息通知系统路由
Route::group(['prefix' => 'api/v1'], function () {
    Route::post('notify', [MessageNotificationController::class, 'sendNotification']);
    Route::get('notifications', [MessageNotificationController::class, 'getNotifications']);
});

// MessageNotificationController 控制器
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Services\NotificationService;

class MessageNotificationController extends Controller
{
    // 发送消息通知
    public function sendNotification(Request $request, NotificationService $notificationService)
    {
        try {
            $data = $request->only(['message', 'user_id']);
            $notificationService->send($data['message'], $data['user_id']);
            
            return response()->json(['success' => true, 'message' => 'Notification sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    // 获取用户通知
    public function getNotifications(Request $request, NotificationService $notificationService)
    {
        try {
            $user_id = $request->user_id;
            $notifications = $notificationService->getByUserId($user_id);
            
            return response()->json(['success' => true, 'data' => $notifications]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}

// NotificationService 服务
namespace App\Services;

use App\Models\Message;

class NotificationService
{
    // 发送通知
    public function send($message, $user_id)
    {
        // 这里可以添加发送通知的逻辑，例如邮件、短信等
        // 将消息存储到数据库
        $message = Message::create(['message' => $message, 'user_id' => $user_id]);

        // 返回成功消息
        return $message;
    }

    // 根据用户ID获取通知
    public function getByUserId($user_id)
    {
        // 从数据库获取通知
        $notifications = Message::where('user_id', $user_id)->get();

        // 返回通知列表
        return $notifications;
    }
}

// Message 模型
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // 指定表名
    protected $table = 'messages';

    // 可批量赋值的属性
    protected $fillable = ['message', 'user_id'];
}
