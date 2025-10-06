<?php
// 代码生成时间: 2025-10-06 21:17:56
class OptionPricingModel {

    /**
     * Calculate the price of a European call option.
     *
     * @param float $s Current stock price.
     * @param float $k Strike price of the option.
     * @param float $t Time to expiration in years.
     * @param float $r Risk-free interest rate (as a decimal).
     * @param float $sigma Volatility of the underlying asset (as a decimal).
     *
     * @return float The theoretical price of the call option.
     */
    public function calculateCallOptionPrice($s, $k, $t, $r, $sigma) {
        if ($s <= 0 || $k <= 0 || $t <= 0 || $r < 0 || $sigma <= 0) {
            // Handle invalid input by throwing an exception.
            throw new InvalidArgumentException('Invalid input for option pricing calculation.');
        }

        $d1 = (log($s / $k) + ($r + pow($sigma, 2) / 2) * $t) / ($sigma * sqrt($t));
        $d2 = $d1 - $sigma * sqrt($t);

        $call = $s * exp(-1 * $r * $t) * self::cnd($d1) - $k * exp(-1 * $r * $t) * self::cnd($d2);

        return $call;
    }

    /**
     * Calculate the price of a European put option.
     *
     * @param float $s Current stock price.
     * @param float $k Strike price of the option.
     * @param float $t Time to expiration in years.
     * @param float $r Risk-free interest rate (as a decimal).
     * @param float $sigma Volatility of the underlying asset (as a decimal).
     *
     * @return float The theoretical price of the put option.
     */
    public function calculatePutOptionPrice($s, $k, $t, $r, $sigma) {
        if ($s <= 0 || $k <= 0 || $t <= 0 || $r < 0 || $sigma <= 0) {
            throw new InvalidArgumentException('Invalid input for option pricing calculation.');
        }

        $d1 = (log($s / $k) + ($r + pow($sigma, 2) / 2) * $t) / ($sigma * sqrt($t));
        $d2 = $d1 - $sigma * sqrt($t);

        $put = $k * exp(-1 * $r * $t) * self::cnd(-$d2) - $s * exp(-1 * $r * $t) * self::cnd(-$d1);

        return $put;
    }

    /**
     * The cumulative standard normal distribution function.
     *
     * @param float $z The value at which to evaluate the distribution.
     *
     * @return float The cumulative probability.
     */
    protected static function cnd($z) {
        $z = max(min($z, 6), -6); // Restrict z to the domain where the approximation is valid.
        $x = 1 / (1 + 0.2316419 * $z);
        $cnd = 1 - 1 / sqrt(2 * pi()) * exp(-0.5 * pow($z, 2)) * (
            0.3193819 + $x * (-0.356563782 + $x * (1.781477937 + $x * (-1.821255978 + $x * 1.3302744214))));

        return $cnd;
    }
}

// Example usage:
try {
    $model = new OptionPricingModel();
    $callPrice = $model->calculateCallOptionPrice(100, 105, 1, 0.05, 0.2);
    $putPrice = $model->calculatePutOptionPrice(100, 105, 1, 0.05, 0.2);
    echo "Call Option Price: $callPrice
";
    echo "Put Option Price: $putPrice
";
} catch (Exception $e) {
    echo "Error in option pricing model: " . $e->getMessage();
}
