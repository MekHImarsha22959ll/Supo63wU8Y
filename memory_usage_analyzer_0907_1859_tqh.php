<?php
// 代码生成时间: 2025-09-07 18:59:27
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\File\UploadedFile;

// 内存使用情况分析控制器
class MemoryUsageAnalyzerController extends Controller
{
    // 内存使用分析方法
    public function analyze(Request $request)
    {
        // 获取请求数据
        if (!$request->has('action')) {
            return response()->json(['error' => 'Missing action parameter'], Response::HTTP_BAD_REQUEST);
        }

        $action = $request->input('action');

        // 根据请求动作执行不同的内存使用分析操作
        switch ($action) {
            case 'get_peak_usage':
                return $this->getPeakMemoryUsage();
            case 'get_current_usage':
                return $this->getCurrentMemoryUsage();
            default:
                return response()->json(['error' => 'Invalid action'], Response::HTTP_BAD_REQUEST);
        }
    }

    // 获取峰值内存使用情况
    private function getPeakMemoryUsage()
    {
        $peakMemory = memory_get_peak_usage(true);

        // 转换内存单位
        $memoryUnits = [
            'K' => 1024,
            'M' => 1024 * 1024,
            'G' => 1024 * 1024 * 1024
        ];

        foreach ($memoryUnits as $unit => $size) {
            if ($peakMemory < $size) {
                return response()->json(['peak_memory' => $peakMemory . $unit]);
            }
            $peakMemory /= $size;
        }

        return response()->json(['peak_memory' => $peakMemory . 'G']);
    }

    // 获取当前内存使用情况
    private function getCurrentMemoryUsage()
    {
        $currentMemory = memory_get_usage(true);

        // 转换内存单位
        $memoryUnits = [
            'K' => 1024,
            'M' => 1024 * 1024,
            'G' => 1024 * 1024 * 1024
        ];

        foreach ($memoryUnits as $unit => $size) {
            if ($currentMemory < $size) {
                return response()->json(['current_memory' => $currentMemory . $unit]);
            }
            $currentMemory /= $size;
        }

        return response()->json(['current_memory' => $currentMemory . 'G']);
    }
}
