<?php
// 代码生成时间: 2025-09-09 13:24:06
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

// ApiResponseFormatter 类用于格式化 API 响应
class ApiResponseFormatter extends Controller
{
    // 成功响应
    public static function success($data = [], $message = 'Operation successful', $statusCode = Response::HTTP_OK)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    // 错误响应
    public static function error($message = 'Operation failed', $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }

    // 未授权响应
    public static function unauthorized($message = 'Unauthorized access')
    {
        return self::error($message, Response::HTTP_UNAUTHORIZED);
    }

    // 未找到响应
    public static function notFound($message = 'Resource not found')
    {
        return self::error($message, Response::HTTP_NOT_FOUND);
    }

    // 验证失败响应
    public static function validationFailed($message = 'Validation failed')
    {
        return self::error($message, Response::HTTP_BAD_REQUEST);
    }
}

// 使用示例
// $apiResponse = ApiResponseFormatter::success(['user' => 'John Doe']);
// $apiResponse = ApiResponseFormatter::error('Something went wrong');
// $apiResponse = ApiResponseFormatter::unauthorized('You are not allowed to access this resource');
// $apiResponse = ApiResponseFormatter::notFound('The requested resource was not found');
// $apiResponse = ApiResponseFormatter::validationFailed('Invalid input');
