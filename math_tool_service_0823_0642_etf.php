<?php
// 代码生成时间: 2025-08-23 06:42:26
class MathToolService {

    /**
     * Adds two numbers.
     *
     * @param float $a First number.
     * @param float $b Second number.
     * @return float Result of addition.
     * @throws InvalidArgumentException If the input is not a number.
     */
    public function add(float $a, float $b): float {
        if (!is_float($a) || !is_float($b)) {
            throw new InvalidArgumentException('Both parameters must be numbers.');
        }

        return $a + $b;
    }

    /**
     * Subtracts second number from the first.
     *
     * @param float $a First number.
     * @param float $b Second number.
     * @return float Result of subtraction.
     * @throws InvalidArgumentException If the input is not a number.
     */
    public function subtract(float $a, float $b): float {
        if (!is_float($a) || !is_float($b)) {
            throw new InvalidArgumentException('Both parameters must be numbers.');
        }

        return $a - $b;
    }

    /**
     * Multiplies two numbers.
     *
     * @param float $a First number.
     * @param float $b Second number.
     * @return float Result of multiplication.
     * @throws InvalidArgumentException If the input is not a number.
     */
    public function multiply(float $a, float $b): float {
        if (!is_float($a) || !is_float($b)) {
            throw new InvalidArgumentException('Both parameters must be numbers.');
        }

        return $a * $b;
    }

    /**
     * Divides the first number by the second.
     *
     * @param float $a First number (numerator).
     * @param float $b Second number (denominator).
     * @return float Result of division.
     * @throws InvalidArgumentException If the input is not a number or denominator is zero.
     */
    public function divide(float $a, float $b): float {
        if (!is_float($a) || !is_float($b)) {
            throw new InvalidArgumentException('Both parameters must be numbers.');
        }

        if ($b == 0) {
            throw new InvalidArgumentException('Denominator cannot be zero.');
        }

        return $a / $b;
    }
}

// Example usage:
// $math = new MathToolService();
// echo $math->add(10, 5); // Outputs: 15
// echo $math->subtract(10, 5); // Outputs: 5
// echo $math->multiply(10, 5); // Outputs: 50
// echo $math->divide(10, 5); // Outputs: 2
