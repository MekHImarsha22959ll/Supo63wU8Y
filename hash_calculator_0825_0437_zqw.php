<?php
// 代码生成时间: 2025-08-25 04:37:43
namespace App\Services;

use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class HashCalculator {

    /**
     * Calculate hash for a given value.
     *
     * @param string $value The value to be hashed.
     * @param string $algorithm The hashing algorithm to use.
     * @return string The calculated hash.
     * @throws InvalidArgumentException If the algorithm is not supported.
     */
    public function calculateHash(string $value, string $algorithm = 'sha256'): string
    {
        if (!in_array($algorithm, hash_algos())) {
            throw new InvalidArgumentException("Unsupported hashing algorithm: {$algorithm}.");
        }

        return Hash::make($value, [
            'driver' => 'bcrypt', // Laravel's built-in bcrypt driver
            'rounds' => 10,       // Number of rounds for bcrypt hashing
            'algorithm' => $algorithm, // The hashing algorithm to use
        ]);
    }
}
