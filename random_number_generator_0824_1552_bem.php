<?php
// 代码生成时间: 2025-08-24 15:52:17
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use InvalidArgumentException;

class RandomNumberGenerator {
    /**
     * Generate a random number within a specified range.
     *
     * @param int $min Minimum value of the range (inclusive)
     * @param int $max Maximum value of the range (inclusive)
     * @return int Random number within the specified range
     * @throws InvalidArgumentException If the range is invalid
     */
    public function generate(int $min, int $max): int {
        // Validate the range
        if ($min > $max) {
            throw new InvalidArgumentException('The minimum value cannot be greater than the maximum value.');
        }

        // Generate and return a random number within the range
        return rand($min, $max);
    }
}

// Define routes for the application
Route::get('/random-number', function () {
    // Get the minimum and maximum values from the request query parameters
    $min = request('min', 1);
    $max = request('max', 100);

    try {
        // Create an instance of the RandomNumberGenerator class
        $generator = new RandomNumberGenerator();

        // Generate a random number within the specified range
        $randomNumber = $generator->generate((int) $min, (int) $max);

        // Return the random number as a JSON response
        return response()->json(['randomNumber' => $randomNumber]);
    } catch (InvalidArgumentException $e) {
        // Return an error response if the range is invalid
        return response()->json(['error' => $e->getMessage()], 400);
    }
});
