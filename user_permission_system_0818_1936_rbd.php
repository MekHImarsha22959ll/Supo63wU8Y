<?php
// 代码生成时间: 2025-08-18 19:36:00
// user_permission_system.php
// 使用Laravel框架实现用户权限管理系统

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;

// 用户模型
class User extends Model
{
    // 用户模型注释
    protected $fillable = ['name', 'email', 'password'];
}

// 权限模型
class Permission extends Model
{
    // 权限模型注释
    protected $fillable = ['name', 'description'];
}

// 角色模型
class Role extends Model
{
    // 角色模型注释
    protected $fillable = ['name', 'description'];

    // 角色与权限的多对多关系
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}

// 权限迁移文件
class CreatePermissionsTable extends Migration
{
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}

// 角色迁移文件
class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
}

// 权限与角色迁移文件
class CreateRolePermissionTable extends Migration
{
    public function up()
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_permission');
    }
}

// 用户与角色关系迁移文件
class CreateUserRoleTable extends Migration
{
    public function up()
    {
        Schema::create('user_role', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_role');
    }
}

// 用户权限控制器
class UserPermissionController extends Controller
{
    // 获取用户权限
    public function getUserPermissions($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $roles = $user->roles;
            $permissions = Permission::whereIn('id', $roles->pluck('permissions')->flatten())->get();
            return response()->json($permissions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // 分配权限给角色
    public function assignPermissionToRole(Request $request, $roleId)
    {
        try {
            $role = Role::findOrFail($roleId);
            $permissions = Permission::whereIn('id', $request->input('permissions'))->get();
            $role->permissions()->sync($permissions);
            return response()->json(['message' => 'Permission assigned successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

// 路由文件
Route::get('/user/{userId}/permissions', [UserPermissionController::class, 'getUserPermissions']);
Route::post('/role/{roleId}/assign-permission', [UserPermissionController::class, 'assignPermissionToRole']);

?>