<?php
// 代码生成时间: 2025-08-15 00:30:57
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

// InventoryItem Model
class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'quantity', 'price'];

    protected static function boot()
    {
        parent::boot();

        // 自定义查询作用域，用于获取库存不足的商品
        static::addGlobalScope('low_stock', function (Builder $builder) {
            $builder->having('quantity', '<', 10);
        });
    }
}

// InventoryService Service
class InventoryService
{
    public function addInventoryItem($name, $quantity, $price)
    {
        $validator = Validator::make(
            ['name' => $name, 'quantity' => $quantity, 'price' => $price],
            ['name' => 'required|string', 'quantity' => 'required|integer|min:1', 'price' => 'required|numeric|min:0.01']
        );

        if ($validator->fails()) {
            return ['success' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()];
        }

        try {
            $inventoryItem = InventoryItem::create(
                ['name' => $name, 'quantity' => $quantity, 'price' => $price]
            );

            return ['success' => true, 'message' => 'Inventory item added successfully', 'item' => $inventoryItem];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Failed to add inventory item', 'error' => $e->getMessage()];
        }
    }

    public function updateInventoryItem($id, $quantity, $price)
    {
        $validator = Validator::make(
            ['id' => $id, 'quantity' => $quantity, 'price' => $price],
            ['id' => 'required|integer', 'quantity' => 'required|integer|min:1', 'price' => 'required|numeric|min:0.01']
        );

        if ($validator->fails()) {
            return ['success' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()];
        }

        try {
            $inventoryItem = InventoryItem::findOrFail($id);
            $inventoryItem->update(
                ['quantity' => $quantity, 'price' => $price]
            );

            return ['success' => true, 'message' => 'Inventory item updated successfully', 'item' => $inventoryItem];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Failed to update inventory item', 'error' => $e->getMessage()];
        }
    }

    public function deleteInventoryItem($id)
    {
        try {
            $inventoryItem = InventoryItem::findOrFail($id);
            $inventoryItem->delete();

            return ['success' => true, 'message' => 'Inventory item deleted successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Failed to delete inventory item', 'error' => $e->getMessage()];
        }
    }

    public function getLowStockItems()
    {
        return InventoryItem::low_stock()->get();
    }
}
