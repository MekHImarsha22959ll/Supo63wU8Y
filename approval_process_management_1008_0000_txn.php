<?php
// 代码生成时间: 2025-10-08 00:00:41
// approval_process_management.php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

// ApprovalProcess 模型代表审批流程
class ApprovalProcess extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'status'];

    // 关联审批步骤
    public function steps()
    {
        return $this->hasMany(ApprovalStep::class);
    }
}

// ApprovalStep 模型代表审批流程中的单个步骤
class ApprovalStep extends Model
{
    use HasFactory;
    protected $fillable = ['process_id', 'name', 'description', 'status', 'approval_user_id'];

    // 关联审批流程
    public function process()
    {
        return $this->belongsTo(ApprovalProcess::class);
    }

    // 关联审批用户
    public function approvalUser()
    {
        return $this->belongsTo(User::class, 'approval_user_id');
    }
}

// ApprovalProcessService 服务类负责审批流程的业务逻辑
class ApprovalProcessService
{
    // 创建一个新的审批流程
    public function createProcess($data)
    {
        try {
            $process = ApprovalProcess::create($data);
            return $process;
        } catch (\Exception $e) {
            // 错误处理
            return ['error' => $e->getMessage()];
        }
    }

    // 更新审批流程状态
    public function updateProcessStatus($id, $status)
    {
        try {
            $process = ApprovalProcess::find($id);
            if (!$process) {
                throw new \Exception('Process not found.');
            }
            $process->status = $status;
            $process->save();
            return $process;
        } catch (\Exception $e) {
            // 错误处理
            return ['error' => $e->getMessage()];
        }
    }

    // 添加审批步骤
    public function addStep($processId, $data)
    {
        try {
            $step = new ApprovalStep();
            $step->process_id = $processId;
            $step->fill($data);
            $step->save();
            return $step;
        } catch (\Exception $e) {
            // 错误处理
            return ['error' => $e->getMessage()];
        }
    }

    // 审批步骤状态更新
    public function updateStepStatus($stepId, $status)
    {
        try {
            $step = ApprovalStep::find($stepId);
            if (!$step) {
                throw new \Exception('Step not found.');
            }
            $step->status = $status;
            $step->save();
            return $step;
        } catch (\Exception $e) {
            // 错误处理
            return ['error' => $e->getMessage()];
        }
    }
}

// User 模型代表系统中的用户
class User extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'password'];

    // 用户参与的审批步骤
    public function approvalSteps()
    {
        return $this->hasMany(ApprovalStep::class, 'approval_user_id');
    }
}

// 路由定义
// 需要在 Laravel 的路由文件中定义相应的路由
// Route::post('/approval/process', [ApprovalProcessController::class, 'store']);
// Route::put('/approval/process/{id}', [ApprovalProcessController::class, 'update']);
// Route::post('/approval/process/{processId}/step', [ApprovalProcessController::class, 'addStep']);
// Route::put('/approval/step/{stepId}', [ApprovalProcessController::class, 'updateStep']);


/**
 * 控制器定义
 */
class ApprovalProcessController extends Controller
{
    protected $approvalProcessService;

    public function __construct(ApprovalProcessService $approvalProcessService)
    {
        $this->approvalProcessService = $approvalProcessService;
    }

    // 创建审批流程
    public function store(Request $request)
    {
        $data = $request->all();
        $process = $this->approvalProcessService->createProcess($data);
        if (isset($process['error'])) {
            return response()->json(['error' => $process['error']], 400);
        }
        return response()->json($process, 201);
    }

    // 更新审批流程状态
    public function update($id, Request $request)
    {
        $status = $request->input('status');
        $process = $this->approvalProcessService->updateProcessStatus($id, $status);
        if (isset($process['error'])) {
            return response()->json(['error' => $process['error']], 400);
        }
        return response()->json($process);
    }

    // 添加审批步骤
    public function addStep($processId, Request $request)
    {
        $data = $request->all();
        $step = $this->approvalProcessService->addStep($processId, $data);
        if (isset($step['error'])) {
            return response()->json(['error' => $step['error']], 400);
        }
        return response()->json($step, 201);
    }

    // 更新审批步骤状态
    public function updateStep($stepId, Request $request)
    {
        $status = $request->input('status');
        $step = $this->approvalProcessService->updateStepStatus($stepId, $status);
        if (isset($step['error'])) {
            return response()->json(['error' => $step['error']], 400);
        }
        return response()->json($step);
    }
}