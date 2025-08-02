<?php
// 代码生成时间: 2025-08-02 13:54:10
class DataAnalysisTool {

    /**
     * 数据集合
     *
     * @var array
     */
    private $data;

    /**
     * 构造函数
     *
     * @param array $data
     */
    public function __construct(array $data) {
        $this->data = $data;
    }

    /**
     * 计算平均值
     *
     * @return float
     */
    public function calculateAverage(): float {
        if (empty($this->data)) {
            throw new InvalidArgumentException('数据集合不能为空');
        }

        $sum = array_sum($this->data);
        $count = count($this->data);

        return $sum / $count;
    }

    /**
     * 计算中位数
     *
     * @return float
     */
    public function calculateMedian(): float {
        if (empty($this->data)) {
            throw new InvalidArgumentException('数据集合不能为空');
        }

        sort($this->data);
        $count = count($this->data);
        $middleIndex = floor(($count - 1) / 2);

        if ($count % 2) {
            return $this->data[$middleIndex];
        } else {
            return ($this->data[$middleIndex] + $this->data[$middleIndex + 1]) / 2;
        }
    }

    /**
     * 计算众数
     *
     * @return array
     */
    public function calculateMode(): array {
        if (empty($this->data)) {
            throw new InvalidArgumentException('数据集合不能为空');
        }

        $frequencyMap = array_count_values($this->data);
        arsort($frequencyMap);
        $maxFrequency = key($frequencyMap);

        return array_keys($frequencyMap, $maxFrequency);
    }

    /**
     * 计算方差
     *
     * @return float
     */
    public function calculateVariance(): float {
        if (empty($this->data)) {
            throw new InvalidArgumentException('数据集合不能为空');
        }

        $average = $this->calculateAverage();
        $variance = 0;
        foreach ($this->data as $value) {
            $variance += pow($value - $average, 2);
        }

        return $variance / count($this->data);
    }

    /**
     * 计算标准差
     *
     * @return float
     */
    public function calculateStandardDeviation(): float {
        return sqrt($this->calculateVariance());
    }
}
