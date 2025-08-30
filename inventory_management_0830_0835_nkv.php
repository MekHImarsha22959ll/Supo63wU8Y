<?php
// 代码生成时间: 2025-08-30 08:35:55
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// InventoryItem Model for representing inventory items
class InventoryItem extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = ['name', 'quantity', 'description', 'price'];

    // Indicates if the model should be timestamped
    public $timestamps = false;

    // Relationships
    // Define any relationships if needed (e.g., many-to-many, belongs to, etc.)
    // Example: public function category() { return $this->belongsTo(Category::class); }
}

// Inventory Service for business logic
class InventoryService
{
    /**
     * Add a new inventory item to the database.
     *
     * @param array $data
     * @return InventoryItem
     */
    public function addItem(array $data): InventoryItem
    {
        // Validate data before saving
        if (empty($data['name']) || empty($data['quantity'])) {
            throw new InvalidArgumentException('Invalid item data.');
        }

        // Save the new item to the database
        return InventoryItem::create($data);
    }

    /**
     * Update an existing inventory item.
     *
     * @param InventoryItem $item
     * @param array $data
     * @return InventoryItem
     */
    public function updateItem(InventoryItem $item, array $data): InventoryItem
    {
        // Validate data before updating
        if (empty($data['name']) || empty($data['quantity'])) {
            throw new InvalidArgumentException('Invalid item data.');
        }

        // Update the item in the database
        $item->update($data);

        return $item;
    }

    /**
     * Remove an inventory item from the database.
     *
     * @param InventoryItem $item
     * @return bool
     */
    public function deleteItem(InventoryItem $item): bool
    {
        // Delete the item from the database
        return $item->delete();
    }
}

// InventoryController to handle HTTP requests
class InventoryController extends Controller
{
    /**
     * The inventory service instance.
     *
     * @var InventoryService
     */
    protected $inventoryService;

    /**
     * Create a new controller instance.
     *
     * @param InventoryService $inventoryService
     */
    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Display a listing of the inventory items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\Response
    {
        $items = InventoryItem::all();

        return response()->json($items);
    }

    /**
     * Store a newly created inventory item in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(\Illuminate\Http\Request $request): \Illuminate\Http\Response
    {
        try {
            $item = $this->inventoryService->addItem($request->all());

            return response()->json($item, 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Update the specified inventory item in storage.
     *
     * @param \Illuminate\Http\Request $request, InventoryItem $item
     * @return \Illuminate\Http\Response
     */
    public function update(\Illuminate\Http\Request $request, InventoryItem $item): \Illuminate\Http\Response
    {
        try {
            $updatedItem = $this->inventoryService->updateItem($item, $request->all());

            return response()->json($updatedItem);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified inventory item from storage.
     *
     * @param InventoryItem $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(InventoryItem $item): \Illuminate\Http\Response
    {
        try {
            if ($this->inventoryService->deleteItem($item)) {
                return response()->json(['message' => 'Item deleted successfully.'], 200);
            } else {
                return response()->json(['message' => 'Item not found.'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
