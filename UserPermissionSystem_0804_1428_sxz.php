<?php
// 代码生成时间: 2025-08-04 14:28:43
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\UserPermission;
use App\Exceptions\UserPermissionException;

// UserPermissionSystem 负责处理用户权限相关操作
class UserPermissionSystem {

    // 检查用户是否有指定权限
    public function checkPermission($permission) {
        try {
            // 获取当前登录用户
            $user = Auth::user();

            // 检查用户是否存在
            if (!$user) {
                throw new UserPermissionException('User not found');
            }

            // 获取用户权限
            $permissions = UserPermission::where('user_id', $user->id)->get();

            // 检查用户是否有指定权限
            foreach ($permissions as $permission) {
                if ($permission->name === $permission) {
                    return true;
                }
            }

            // 用户没有指定权限
            throw new UserPermissionException('Permission denied');
        } catch (UserPermissionException $e) {
            Log::error('User permission error: ' . $e->getMessage());
            return false;
        }
    }

    // 给用户添加权限
    public function addPermission($userId, $permissionName) {
        try {
            // 检查用户是否存在
            $user = User::find($userId);
            if (!$user) {
                throw new UserPermissionException('User not found');
            }

            // 检查权限是否已存在
            $existingPermission = UserPermission::where('user_id', $userId)->where('name', $permissionName)->first();
            if ($existingPermission) {
                throw new UserPermissionException('Permission already exists');
            }

            // 添加权限
            $newPermission = new UserPermission();
            $newPermission->user_id = $userId;
            $newPermission->name = $permissionName;
            $newPermission->save();

            return true;
        } catch (UserPermissionException $e) {
            Log::error('User permission error: ' . $e->getMessage());
            return false;
        }
    }

    // 删除用户权限
    public function removePermission($userId, $permissionName) {
        try {
            // 检查用户是否存在
            $user = User::find($userId);
            if (!$user) {
                throw new UserPermissionException('User not found');
            }

            // 删除权限
            $permission = UserPermission::where('user_id', $userId)->where('name', $permissionName)->first();
            if (!$permission) {
                throw new UserPermissionException('Permission not found');
            }

            $permission->delete();

            return true;
        } catch (UserPermissionException $e) {
            Log::error('User permission error: ' . $e->getMessage());
            return false;
        }
    }
}
