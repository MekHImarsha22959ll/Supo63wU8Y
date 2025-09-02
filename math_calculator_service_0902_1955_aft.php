<?php
// 代码生成时间: 2025-09-02 19:55:39
use Illuminate\Support\Facades\Validator;

// MathCalculatorService 提供数学计算功能
class MathCalculatorService {
    // 计算两个数的加法
    public function add($a, $b) {
        return $a + $b;
    }

    // 计算两个数的减法
    public function subtract($a, $b) {
        return $a - $b;
    }

    // 计算两个数的乘法
    public function multiply($a, $b) {
        return $a * $b;
    }

    // 计算两个数的除法，确保除数不为零
    public function divide($a, $b) {
        if ($b == 0) {
            throw new InvalidArgumentException('除数不能为零');
        }
        return $a / $b;
    }

    // 计算一个数的平方
    public function square($number) {
        return $number * $number;
    }

    // 计算一个数的立方
    public function cube($number) {
        return $number * $number * $number;
    }
}

// MathCalculatorServiceProvider 服务提供者
class MathCalculatorServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->singleton(MathCalculatorService::class, function ($app) {
            return new MathCalculatorService();
        });
    }

    public function boot() {
        // 这里可以添加服务启动时需要执行的代码
    }
}

// MathCalculatorController 控制器，处理请求
class MathCalculatorController extends Controller {
    protected $mathCalculatorService;

    public function __construct(MathCalculatorService $mathCalculatorService) {
        $this->mathCalculatorService = $mathCalculatorService;
    }

    public function calculate($operation, $a, $b) {
        // 校验请求参数
        $validator = Validator::make(['operation' => $operation, 'a' => $a, 'b' => $b], [
            'operation' => 'required|in:add,subtract,multiply,divide',
            'a' => 'required|numeric',
            'b' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => '无效的请求参数'], 400);
        }

        // 根据操作类型调用相应的方法
        switch ($operation) {
            case 'add':
                return response()->json(['result' => $this->mathCalculatorService->add($a, $b)]);
            case 'subtract':
                return response()->json(['result' => $this->mathCalculatorService->subtract($a, $b)]);
            case 'multiply':
                return response()->json(['result' => $this->mathCalculatorService->multiply($a, $b)]);
            case 'divide':
                try {
                    return response()->json(['result' => $this->mathCalculatorService->divide($a, $b)]);
                } catch (InvalidArgumentException $e) {
                    return response()->json(['error' => $e->getMessage()], 400);
                }
            default:
                return response()->json(['error' => '无效的操作'], 400);
        }
    }

    public function square($number) {
        $validator = Validator::make(['number' => $number], [
            'number' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => '无效的请求参数'], 400);
        }

        return response()->json(['result' => $this->mathCalculatorService->square($number)]);
    }

    public function cube($number) {
        $validator = Validator::make(['number' => $number], [
            'number' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => '无效的请求参数'], 400);
        }

        return response()->json(['result' => $this->mathCalculatorService->cube($number)]);
    }
}
