<?php
// 代码生成时间: 2025-08-03 06:03:00
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

// UserPermission.php
class UserPermission extends Model
{
    // 用户权限模型
    protected $table = 'user_permissions';
    protected $fillable = ['user_id', 'permission_id'];

    // 关联用户模型
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 关联权限模型
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}

// Permission.php
class Permission extends Model
{
    // 权限模型
    protected $table = 'permissions';
    protected $fillable = ['name', 'description'];

    // 关联用户权限模型
    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class);
    }
}

// UserService.php
class UserService
{
    // 添加用户权限
    public function addUserPermission($userId, $permissionId)
    {
        try {
            DB::beginTransaction();
            $userPermission = new UserPermission();
            $userPermission->user_id = $userId;
            $userPermission->permission_id = $permissionId;
            $userPermission->save();
            DB::commit();
            return ['success' => true, 'message' => 'User permission added successfully.'];
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error adding user permission: ', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Failed to add user permission.'];
        }
    }

    // 删除用户权限
    public function removeUserPermission($userId, $permissionId)
    {
        try {
            DB::beginTransaction();
            $userPermission = UserPermission::where('user_id', $userId)->where('permission_id', $permissionId)->first();
            if (!$userPermission) {
                return ['success' => false, 'message' => 'User permission not found.'];
            }
            $userPermission->delete();
            DB::commit();
            return ['success' => true, 'message' => 'User permission removed successfully.'];
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error removing user permission: ', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Failed to remove user permission.'];
        }
    }
}

// UserController.php
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // 添加用户权限
    public function addUserPermission(Request $request)
    {
        $userId = $request->input('user_id');
        $permissionId = $request->input('permission_id');
        $response = $this->userService->addUserPermission($userId, $permissionId);
        return response()->json($response);
    }

    // 删除用户权限
    public function removeUserPermission(Request $request)
    {
        $userId = $request->input('user_id');
        $permissionId = $request->input('permission_id');
        $response = $this->userService->removeUserPermission($userId, $permissionId);
        return response()->json($response);
    }
}
