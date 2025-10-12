<?php
// 代码生成时间: 2025-10-13 03:08:25
class SortingAlgorithm {

    /**
     * Sorts an array of numbers using bubble sort algorithm.
     *
     * @param array $array The array to be sorted.
     * @return array The sorted array.
     */
    public function bubbleSort(array $array): array {
        // Check if the input is a valid array
        if (!is_array($array)) {
            throw new InvalidArgumentException('Input must be an array.');
        }

        // Check if all elements are numeric
        foreach ($array as $value) {
            if (!is_numeric($value)) {
                throw new InvalidArgumentException('All elements must be numeric.');
            }
        }

        $size = count($array);
        for ($i = 0; $i < $size - 1; $i++) {
            for ($j = 0; $j < $size - $i - 1; $j++) {
                if ($array[$j] > $array[$j + 1]) {
                    // Swap the elements
                    $temp = $array[$j];
                    $array[$j] = $array[$j + 1];
                    $array[$j + 1] = $temp;
                }
            }
        }
        return $array;
    }

    /**
     * Sorts an array of numbers using insertion sort algorithm.
     *
     * @param array $array The array to be sorted.
     * @return array The sorted array.
     */
    public function insertionSort(array $array): array {
        // Check if the input is a valid array
        if (!is_array($array)) {
            throw new InvalidArgumentException('Input must be an array.');
        }

        // Check if all elements are numeric
        foreach ($array as $value) {
            if (!is_numeric($value)) {
                throw new InvalidArgumentException('All elements must be numeric.');
            }
        }

        for ($i = 1; $i < count($array); $i++) {
            $key = $array[$i];
            $j = $i - 1;

            while ($j >= 0 && $array[$j] > $key) {
                $array[$j + 1] = $array[$j];
                $j--;
            }
            $array[$j + 1] = $key;
        }
        return $array;
    }

    // Additional sorting algorithms (e.g., selection sort, quick sort, merge sort) can be added here
}

// Example usage
$sortingAlgorithm = new SortingAlgorithm();
$array = [5, 3, 8, 4, 2];

try {
    $sortedArray = $sortingAlgorithm->bubbleSort($array);
    echo "Bubble Sort:
";
    print_r($sortedArray);

    $sortedArray = $sortingAlgorithm->insertionSort($array);
    echo "Insertion Sort:
";
    print_r($sortedArray);
} catch (InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage();
}
