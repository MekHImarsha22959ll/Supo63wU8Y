<?php
// 代码生成时间: 2025-09-29 00:01:20
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Database\QueryException;

/**
 * Privacy Protection Controller
 * Handles privacy settings for users
 */
class PrivacyProtectionController extends Controller
{
    /**
     * Updates user privacy settings
     *
     * @param Request $request The HTTP request
     * @param int $userId The user ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePrivacy(Request $request, int $userId)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'privacy_setting' => 'required|string|max:255',
            ]);

            // Find the user by ID
            $user = User::findOrFail($userId);

            // Update the user's privacy setting
            $user->update(['privacy_setting' => $validated['privacy_setting']]);

            // Return a success response
            return response()->json(['message' => 'Privacy settings updated successfully', 'settings' => $user->privacy_setting], 200);
        } catch (QueryException $e) {
            // Handle database errors
            return response()->json(['error' => 'Database error occurred'], 500);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'An error occurred while updating privacy settings'], 500);
        }
    }
}
