<?php
// 代码生成时间: 2025-09-04 10:07:22
// 使用Laravel框架的API资源控制器来创建RESTful API接口
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item; // 假设有一个模型Item

class ItemController extends Controller
{
    // 显示所有资源
    public function index()
    {
        // 获取所有资源
        $items = Item::all();
        // 返回JSON响应
        return response()->json($items);
    }

    // 显示单个资源
    public function show($id)
    {
        // 根据ID查找资源
        $item = Item::find($id);
        // 如果资源不存在，则返回404错误
        if (!$item) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
        // 返回JSON响应
        return response()->json($item);
    }

    // 存储新资源
    public function store(Request $request)
    {
        // 验证请求数据
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);
        // 创建新资源
        $item = Item::create($validated);
        // 返回JSON响应，包括新创建的资源
        return response()->json($item, 201);
    }

    // 更新资源
    public function update(Request $request, $id)
    {
        // 根据ID查找资源
        $item = Item::find($id);
        // 如果资源不存在，则返回404错误
        if (!$item) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
        // 验证请求数据
        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
        ]);
        // 更新资源
        $item->update($validated);
        // 返回JSON响应
        return response()->json($item);
    }

    // 删除资源
    public function destroy($id)
    {
        // 根据ID查找资源
        $item = Item::find($id);
        // 如果资源不存在，则返回404错误
        if (!$item) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
        // 删除资源
        $item->delete();
        // 返回JSON响应
        return response()->json(['message' => 'Resource deleted'], 204);
    }
}
