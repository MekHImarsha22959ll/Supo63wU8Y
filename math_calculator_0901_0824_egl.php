<?php
// 代码生成时间: 2025-09-01 08:24:12
// 文件名: math_calculator.php
/**
 * 一个简单的数学计算工具集，包含基本的数学运算功能。
 *
 * @author 你的姓名
 * @version 1.0
 */

use Illuminate\Support\Facades\Validator;

class MathCalculator {

    /**
     * 执行加法运算
     *
     * @param float $number1 第一个数字
     * @param float $number2 第二个数字
     * @return float 两个数字的和
     */
    public function add($number1, $number2) {
        return $number1 + $number2;
    }

    /**
     * 执行减法运算
     *
     * @param float $number1 第一个数字
     * @param float $number2 第二个数字
     * @return float 两个数字的差
     */
    public function subtract($number1, $number2) {
        return $number1 - $number2;
    }

    /**
     * 执行乘法运算
     *
     * @param float $number1 第一个数字
     * @param float $number2 第二个数字
     * @return float 两个数字的乘积
     */
    public function multiply($number1, $number2) {
        return $number1 * $number2;
    }

    /**
     * 执行除法运算
     *
     * @param float $number1 第一个数字
     * @param float $number2 第二个数字
     * @return float 两个数字的商
     */
    public function divide($number1, $number2) {
        if ($number2 == 0) {
            throw new InvalidArgumentException('除数不能为0');
        }
        return $number1 / $number2;
    }

    /**
     * 执行平方根运算
     *
     * @param float $number 要计算平方根的数字
     * @return float 数字的平方根
     */
    public function squareRoot($number) {
        if ($number < 0) {
            throw new InvalidArgumentException('负数没有实数平方根');
        }
        return sqrt($number);
    }

    /**
     * 执行幂运算
     *
     * @param float $base 底数
     * @param float $exponent 指数
     * @return float 底数的指数幂
     */
    public function power($base, $exponent) {
        return pow($base, $exponent);
    }
}
