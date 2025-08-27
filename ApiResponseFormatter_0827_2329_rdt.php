<?php
// 代码生成时间: 2025-08-27 23:29:08
namespace App\Http\Utilities;

use Illuminate\Http\Response;
use Throwable;

class ApiResponseFormatter {

    /**
     * Formats a successful API response.
     *
     * @param array \$data The data to be sent in the response.
     * @param int \$status The HTTP status code.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success(array \$data, int \$status = Response::HTTP_OK): \Illuminate\Http\JsonResponse {
        return response()->json([
            'success' => true,
            'data' => \$data,
            'message' => 'Operation successful.',
        ], \$status);
    }

    /**
     * Formats an API response for errors.
     *
     * @param string \$message The error message.
     * @param int \$status The HTTP status code.
     * @param array \$errors Additional error details.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error(string \$message, int \$status, array \$errors = []): \Illuminate\Http\JsonResponse {
        return response()->json([
            'success' => false,
            'message' => \$message,
            'errors' => \$errors,
        ], \$status);
    }

    /**
     * Handles exceptions and formats the response accordingly.
     *
     * @param Throwable \$exception The exception to handle.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function exception(Throwable \$exception): \Illuminate\Http\JsonResponse {
        // Log the exception details for debugging purposes.
        \Log::error(\$exception);

        // Determine the appropriate HTTP status code based on the exception type.
        \$status = \$exception instanceof \Illuminate\Database\QueryException ? Response::HTTP_BAD_REQUEST : Response::HTTP_INTERNAL_SERVER_ERROR;

        // Return a formatted error response.
        return self::error(\$exception->getMessage(), \$status);
    }
}
