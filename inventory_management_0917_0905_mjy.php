<?php
// 代码生成时间: 2025-09-17 09:05:40
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

// InventoryItem Model
class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'quantity', 'price', 'supplier_id'];

    // Relationship to Supplier
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}

// Supplier Model
class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone'];

    // Relationship to InventoryItems
    public function inventoryItems(): HasMany
    {
        return $this->hasMany(InventoryItem::class);
    }
}

// InventoryController
class InventoryController extends Controller
{
    public function index()
    {
        // Fetch all inventory items with supplier information
        $inventoryItems = InventoryItem::with('supplier')->get();

        return view('inventory.index', compact('inventoryItems'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric',
            'supplier_id' => 'required|exists:suppliers,id'
        ]);

        // Create a new inventory item
        $inventoryItem = InventoryItem::create($validatedData);

        // Return a success response
        return redirect()->route('inventory.index')->with('success', 'Inventory item added successfully.');
    }

    public function edit(InventoryItem $inventoryItem)
    {
        // Fetch the specific inventory item with supplier information
        $inventoryItem->load('supplier');

        // Pass the item to the edit view
        return view('inventory.edit', compact('inventoryItem'));
    }

    public function update(Request $request, InventoryItem $inventoryItem)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric',
            'supplier_id' => 'required|exists:suppliers,id'
        ]);

        // Update the inventory item
        $inventoryItem->update($validatedData);

        // Return a success response
        return redirect()->route('inventory.index')->with('success', 'Inventory item updated successfully.');
    }

    public function destroy(InventoryItem $inventoryItem)
    {
        // Delete the inventory item
        $inventoryItem->delete();

        // Return a success response
        return redirect()->route('inventory.index')->with('success', 'Inventory item deleted successfully.');
    }
}

// Routes
Route::controller(InventoryController::class)->group(function () {
    Route::get('/inventory', 'index');
    Route::post('/inventory', 'store');
    Route::get('/inventory/{inventoryItem}/edit', 'edit');
    Route::put('/inventory/{inventoryItem}', 'update');
    Route::delete('/inventory/{inventoryItem}', 'destroy');
});

// Migration for Suppliers
class CreateSuppliersTable extends Migration
{
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}

// Migration for InventoryItems
class CreateInventoryItemsTable extends Migration
{
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->foreignId('supplier_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_items');
    }
}

?>