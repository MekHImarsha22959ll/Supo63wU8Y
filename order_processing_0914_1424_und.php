<?php
// 代码生成时间: 2025-09-14 14:24:56
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Exceptions\OrderException;
use Illuminate\Support\Facades\Log;

/**
 * 订单处理类
 *
 * 该类负责处理订单的业务逻辑，包括创建订单、更新订单状态等。
 */
class OrderProcessing {

    /**
     * 创建订单
     *
     * @param array $orderData 订单数据
     * @return Order|null
     * @throws OrderException
     */
    public function createOrder(array $orderData): ?Order {
        try {
            // 开启数据库事务
            DB::beginTransaction();
            
            // 创建订单
            $order = Order::create($orderData);
            
            // 创建订单状态记录
            OrderStatus::create(['order_id' => $order->id, 'status' => 'pending']);
            
            // 提交事务
            DB::commit();
            
            return $order;
        } catch (\Exception $e) {
            // 回滚事务
            DB::rollBack();
            
            // 记录错误日志
            Log::error('Order creation failed: ' . $e->getMessage());
            
            // 抛出自定义异常
            throw new OrderException('Order creation failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * 更新订单状态
     *
     * @param int $orderId 订单ID
     * @param string $newStatus 新的订单状态
     * @return bool
     * @throws OrderException
     */
    public function updateOrderStatus(int $orderId, string $newStatus): bool {
        try {
            // 开启数据库事务
            DB::beginTransaction();
            
            // 更新订单状态
            $orderStatus = OrderStatus::where('order_id', $orderId)->first();
            if (!$orderStatus) {
                throw new OrderException('Order status not found');
            }
            $orderStatus->update(['status' => $newStatus]);
            
            // 提交事务
            DB::commit();
            
            return true;
        } catch (\Exception $e) {
            // 回滚事务
            DB::rollBack();
            
            // 记录错误日志
            Log::error('Order status update failed: ' . $e->getMessage());
            
            // 抛出自定义异常
            throw new OrderException('Order status update failed: ' . $e->getMessage(), 0, $e);
        }
    }
}
