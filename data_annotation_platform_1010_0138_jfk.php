<?php
// 代码生成时间: 2025-10-10 01:38:28
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class Annotation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'data', 'label', 'created_at', 'updated_at'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

class AnnotationService
{
    // Create a new annotation
    public function createAnnotation($data)
    {
        try {
            $validator = Validator::make($data, [
                'user_id' => 'required|integer',
                'data' => 'required|string',
                'label' => 'required|string',
            ]);

            if ($validator->fails()) {
                throw new \Exception('Invalid data provided.', 1);
            }

            $annotation = Annotation::create($data);
            return response()->json(['message' => 'Annotation created successfully.', 'annotation' => $annotation], 201);
        } catch (QueryException $e) {
            Log::error('Database query failed: ' . $e->getMessage());
            return response()->json(['message' => 'Database query failed.'], 500);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    // Get all annotations for a user
    public function getAnnotationsByUser($userId)
    {
        try {
            $annotations = Annotation::where('user_id', $userId)->get();
            return response()->json(['annotations' => $annotations], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('User not found: ' . $e->getMessage());
            return response()->json(['message' => 'User not found.'], 404);
        } catch (QueryException $e) {
            Log::error('Database query failed: ' . $e->getMessage());
            return response()->json(['message' => 'Database query failed.'], 500);
        }
    }
}
