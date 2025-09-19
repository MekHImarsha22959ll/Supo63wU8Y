<?php
// 代码生成时间: 2025-09-19 23:18:26
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

// Define a product model to interact with the database
class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'quantity', 'price'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';
}

// Define the InventoryService class to handle business logic
class InventoryService
{
    /**
     * Add a new product to the inventory.
     *
     * @param array $data The product data.
     * @return Product|bool
     */
    public function addProduct(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            return false;
        }

        return Product::create($data);
    }

    /**
     * Update an existing product in the inventory.
     *
     * @param int $id The product ID.
     * @param array $data The updated product data.
     * @return Product|bool
     */
    public function updateProduct(int $id, array $data)
    {
        $product = Product::find($id);

        if (!$product) {
            // Handle product not found
            return false;
        }

        $validator = Validator::make($data, [
            'name' => 'string|max:255',
            'quantity' => 'integer|min:0',
            'price' => 'numeric'
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            return false;
        }

        $product->update($data);

        return $product;
    }

    /**
     * Remove a product from the inventory.
     *
     * @param int $id The product ID.
     * @return bool
     */
    public function removeProduct(int $id)
    {
        $product = Product::find($id);

        if (!$product) {
            // Handle product not found
            return false;
        }

        return $product->delete();
    }

    /**
     * Get all products in the inventory.
     *
     * @return Collection
     */
    public function getAllProducts()
    {
        return Product::all();
    }
}

// Define the InventoryController to handle HTTP requests
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
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->inventoryService->getAllProducts();

        return response()->json($products);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = $this->inventoryService->addProduct($request->all());

        if (!$product) {
            // Handle product creation failure
            return response()->json(['error' => 'Failed to create product.'], 400);
        }

        return response()->json($product, 201);
    }

    /**
     * Update the specified product in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $product = $this->inventoryService->updateProduct($id, $request->all());

        if (!$product) {
            // Handle product update failure
            return response()->json(['error' => 'Failed to update product.'], 400);
        }

        return response()->json($product);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $result = $this->inventoryService->removeProduct($id);

        if (!$result) {
            // Handle product removal failure
            return response()->json(['error' => 'Failed to remove product.'], 400);
        }

        return response()->json([], 204);
    }
}
