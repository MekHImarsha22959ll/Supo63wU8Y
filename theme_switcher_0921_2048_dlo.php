<?php
// 代码生成时间: 2025-09-21 20:48:11
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

// ThemeSwitcherController 是负责处理主题切换的控制器
class ThemeSwitcherController extends Controller
{
    // 保存当前用户的主题偏好
    public function store(Request $request)
    {
        // 检查请求是否包含主题名称
        if (!$request->has('theme')) {
            return response()->json(['error' => 'Theme name is required.'], 400);
        }

        // 获取主题名称
        $theme = $request->input('theme');

        // 验证主题名称是否有效
        if (!$this->isValidTheme($theme)) {
            return response()->json(['error' => 'Invalid theme name.'], 400);
        }

        // 将主题名称保存到会话中
        Session::put('theme', $theme);

        // 返回成功响应
        return response()->json(['message' => 'Theme switched successfully.', 'theme' => $theme]);
    }

    // 检查主题名称是否在允许的主题列表中
    protected function isValidTheme($theme)
    {
        // 定义允许的主题列表
        $validThemes = ['light', 'dark', 'colorful'];

        // 检查主题名称是否在列表中
        return in_array($theme, $validThemes);
    }
}
