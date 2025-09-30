<?php
// 代码生成时间: 2025-09-30 23:36:49
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\Factory;

class HealthInsuranceSettlement {
    // 医保结算模型
    public function __construct() {
        // 初始化医保结算系统
    }

    /**
     * 进行医保结算
     * 
     * @param array $params 包含病人和费用信息的参数
     * @return array 结算结果
     */
    public function settle(array $params): array {
        try {
            // 参数验证
            if (empty($params['patient_id']) || empty($params['cost'])) {
                throw new Exception('缺少必要的参数');
            }

            // 计算医保支付金额
            $reimbursement = $this->calculateReimbursement($params['patient_id'], $params['cost']);

            // 更新病人的医保账户余额
            $this->updatePatientBalance($params['patient_id'], $reimbursement);

            // 返回结算结果
            return [
                'status' => 'success',
                'message' => '医保结算成功',
                'reimbursement' => $reimbursement,
            ];
        } catch (Exception $e) {
            // 错误处理
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * 计算医保报销金额
     * 
     * @param int $patient_id 病人ID
     * @param float $cost 医疗费用
     * @return float 医保报销金额
     */
    private function calculateReimbursement(int $patient_id, float $cost): float {
        // 根据病人ID获取医保政策
        $policy = DB::table('insurance_policy')->where('patient_id', $patient_id)->first();

        // 如果没有医保政策，返回0
        if (!$policy) {
            return 0;
        }

        // 根据医保政策计算报销金额
        $reimbursement = $cost * $policy->reimbursement_ratio;

        return $reimbursement;
    }

    /**
     * 更新病人的医保账户余额
     * 
     * @param int $patient_id 病人ID
     * @param float $reimbursement 医保报销金额
     */
    private function updatePatientBalance(int $patient_id, float $reimbursement): void {
        // 获取病人的当前医保账户余额
        $current_balance = DB::table('patient')->where('id', $patient_id)->value('insurance_balance');

        // 更新医保账户余额
        DB::table('patient')
            ->where('id', $patient_id)
            ->update(['insurance_balance' => $current_balance - $reimbursement]);
    }
}
