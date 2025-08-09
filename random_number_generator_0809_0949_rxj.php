<?php
// 代码生成时间: 2025-08-09 09:49:43
class RandomNumberGenerator 
{
    /**
     * Generate a random number within a specified range.
     *
     * @param int $min The minimum value of the range.
     * @param int $max The maximum value of the range.
     * @return int The generated random number.
     * @throws InvalidArgumentException If the minimum value is greater than the maximum value.
     */
    public function generate(int $min, int $max): int 
    {
        // Ensure the minimum value is not greater than the maximum value
        if ($min > $max) {
            throw new InvalidArgumentException('The minimum value cannot be greater than the maximum value.');
        }

        // Generate and return a random number within the specified range
        return random_int($min, $max);
    }
}

// Example usage:
try {
    $generator = new RandomNumberGenerator();
    $randomNumber = $generator->generate(1, 100);
    echo "Generated random number: $randomNumber\
";
} catch (InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage() . "\
";
}
