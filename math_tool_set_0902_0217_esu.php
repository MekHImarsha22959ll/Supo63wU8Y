<?php
// 代码生成时间: 2025-09-02 02:17:12
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * MathToolSet provides a collection of mathematical operations.
 */
class MathToolSet extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $this->validate($request, ['a' => 'required|numeric', 'b' => 'required|numeric']);
        $result = $request->input('a') + $request->input('b');
        return response()->json(['result' => $result]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subtract(Request $request)
    {
        $this->validate($request, ['a' => 'required|numeric', 'b' => 'required|numeric']);
        $result = $request->input('a') - $request->input('b');
        return response()->json(['result' => $result]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function multiply(Request $request)
    {
        $this->validate($request, ['a' => 'required|numeric', 'b' => 'required|numeric']);
        $result = $request->input('a') * $request->input('b');
        return response()->json(['result' => $result]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function divide(Request $request)
    {
        $this->validate($request, ['a' => 'required|numeric', 'b' => 'required|numeric']);
        $b = $request->input('b');
        if ($b == 0) {
            return response()->json(['error' => 'Division by zero is not allowed.'], 400);
        }
        $result = $request->input('a') / $b;
        return response()->json(['result' => $result]);
    }
}
