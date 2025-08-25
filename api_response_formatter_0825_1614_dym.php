<?php
// 代码生成时间: 2025-08-25 16:14:15
namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class ApiResponseFormatter
{
    /**
     * 格式化成功的响应
     *
     * @param array $data 响应数据
     * @param int $statusCode HTTP状态码
     * @param array $headers 响应头
     * @return JsonResponse
     */
    public function success(array $data, int $statusCode = 200, array $headers = []): JsonResponse
    {
        return response()->json(
            ['data' => $data, 'status' => 'success'],
            $statusCode,
            $headers
        );
    }

    /**
     * 格式化失败的响应
     *
     * @param string $message 错误信息
     * @param int $statusCode HTTP状态码
     * @param array $headers 响应头
     * @param array $errors 错误详情
     * @return JsonResponse
     */
    public function error(string $message, int $statusCode = 500, array $headers = [], array $errors = []): JsonResponse
    {
        return response()->json(
            ['status' => 'error', 'message' => $message, 'errors' => $errors],
            $statusCode,
            $headers
        );
    }

    /**
     * 格式化分页响应
     *
     * @param \Illuminate\Pagination\LengthAwarePaginator $paginator 分页器
     * @param int $statusCode HTTP状态码
     * @param array $headers 响应头
     * @return JsonResponse
     */
    public function paginate(\Illuminate\Pagination\LengthAwarePaginator $paginator, int $statusCode = 200, array $headers = []): JsonResponse
    {
        return response()->json(
            [
                'data' => $paginator->items(),
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'from' => $paginator->firstItem(),
                    'to' => $paginator->lastItem(),
                    'total' => $paginator->total(),
                    'per_page' => $paginator->perPage(),
                    'last_page' => $paginator->lastPage(),
                ],
                'status' => 'success'
            ],
            $statusCode,
            $headers
        );
    }
}
