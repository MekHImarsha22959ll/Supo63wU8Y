<?php
// 代码生成时间: 2025-08-26 13:06:00
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UrlValidator {
    /**
     * Validate a given URL.
     *
     * @param string $url The URL to be validated.
     * @return bool
     * @throws ValidationException
     */
    public function validate($url) {
        // Define the validation rules for the URL.
        $rules = [
            'url' => 'required|url',
        ];

        // Create a new Validator instance.
        $validator = Validator::make(compact('url'), $rules);

        // Check if the validation fails.
        if ($validator->fails()) {
            // Throw an exception with the error messages.
            throw new ValidationException($validator);
        }

        // If the URL is valid, check if it is reachable.
        try {
            $response = Http::head($url);

            // If the response status code is not 200, the URL is not reachable.
            if ($response->status() !== 200) {
                throw new ValidationException(Validator::make($url, ['url' => 'url_reachable'])->errors());
            }
        } catch (\Exception $e) {
            // Catch any exceptions and throw a ValidationException.
            throw new ValidationException(Validator::make($url, ['url' => 'url_reachable'])->errors());
        }

        // Return true if the URL is valid and reachable.
        return true;
    }
}

// Example usage:
try {
    $urlValidator = new UrlValidator();
    $result = $urlValidator->validate("https://example.com");
    echo "URL is valid and reachable: " . ($result ? 'Yes' : 'No');
} catch (ValidationException $e) {
    echo "Validation errors:\
" . implode("\
", $e->validator->errors()->all());
}
