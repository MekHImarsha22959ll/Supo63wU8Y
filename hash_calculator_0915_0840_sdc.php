<?php
// 代码生成时间: 2025-09-15 08:40:08
use Illuminate\Support\Str;

// 哈希值计算工具
class HashCalculator {

    /**
     * 计算字符串的哈希值
     *
     * @param string $input 输入字符串
     * @param string $algorithm 哈希算法，默认为sha256
     * @return string 哈希值
     * @throws InvalidArgumentException 如果输入字符串为空
     */
    public function calculateHash(string $input, string $algorithm = 'sha256'): string {
        if (empty($input)) {
            throw new InvalidArgumentException('输入字符串不能为空');
        }

        // 使用 Laravel 的 Str 类计算哈希值
        return hash($algorithm, $input);
    }
}

// 示例用法
try {
    $hashCalculator = new HashCalculator();
    $inputString = 'Hello, World!';
    $hashValue = $hashCalculator->calculateHash($inputString);
    echo "输入字符串: {$inputString} \
哈希值: {$hashValue}";
} catch (InvalidArgumentException $e) {
    echo "错误: {$e->getMessage()}";
}
