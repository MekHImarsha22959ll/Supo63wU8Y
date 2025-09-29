<?php
// 代码生成时间: 2025-09-30 02:57:28
// RFIDTagManagement.php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RFIDTag extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = ['id', 'tag_number', 'description', 'location_id'];

    // The attributes that should be hidden for arrays.
    protected $hidden = ['created_at', 'updated_at'];

    // Relation to Location model
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    // Method to handle tag activation
    public function activate(): bool
    {
        try {
            $this->status = 'active';
            $this->tag_number = strtoupper($this->tag_number); // Ensuring the tag number is uppercase
            $this->save();
            return true;
        } catch (\Exception $e) {
            // Log error and return false if activation fails
            \Log::error('Tag activation failed: ' . $e->getMessage());
            return false;
        }
    }

    // Method to handle tag deactivation
    public function deactivate(): bool
    {
        try {
            $this->status = 'inactive';
            $this->save();
            return true;
        } catch (\Exception $e) {
            // Log error and return false if deactivation fails
            \Log::error('Tag deactivation failed: ' . $e->getMessage());
            return false;
        }
    }
}

class Location extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = ['id', 'name', 'address'];

    // Relation to RFIDTag model
    public function tags(): HasMany
    {
        return $this->hasMany(RFIDTag::class);
    }
}

// RFIDTagSeeder.php
class RFIDTagSeeder extends Seeder
{
    public function run(): void
    {
        // Seed data for RFID tags
        $tags = [
            ['tag_number' => 'ABC123', 'description' => 'Entrance tag', 'location_id' => 1],
            ['tag_number' => 'XYZ789', 'description' => 'Exit tag', 'location_id' => 2],
        ];

        foreach ($tags as $tag) {
            RFIDTag::create($tag);
        }
    }
}

// RFIDTagController.php
class RFIDTagController extends Controller
{
    public function index(): Collection
    {
        return RFIDTag::all();
    }

    public function show(RFIDTag $tag): RFIDTag
    {
        return $tag;
    }

    public function store(Request $request): RFIDTag
    {
        $validatedData = $request->validate([
            'tag_number' => 'required|unique:rfid_tags',
            'description' => 'required',
            'location_id' => 'required|exists:locations,id',
        ]);

        return RFIDTag::create($validatedData);
    }

    public function update(Request $request, RFIDTag $tag): RFIDTag
    {
        $validatedData = $request->validate([
            'tag_number' => 'required',
            'description' => 'required',
            'location_id' => 'required|exists:locations,id',
        ]);

        $tag->update($validatedData);

        return $tag;
    }

    public function destroy(RFIDTag $tag): bool
    {
        $tag->delete();
        return true;
    }
}

// Exceptions and error handling should be implemented according to the application requirements.
// This code is a starting point and should be extended with additional functionality and error handling as needed.

