<?php
// 代码生成时间: 2025-08-05 02:51:52
namespace App\Services;

use Illuminate\Support\Facades\Log;

class SortAlgorithm
{
    /**
     * Bubble Sort implementation.
     *
     * @param array $array The array to sort.
     * @return array The sorted array.
     */
    public static function bubbleSort(array $array): array
    {
        for ($i = 0; $i < count($array); $i++) {
            for ($j = 0; $j < count($array) - $i - 1; $j++) {
                if ($array[$j] > $array[$j + 1]) {
                    // Swap elements if they are in the wrong order.
                    $array[$j] ^= $array[$j + 1] ^= $array[$j] ^= $array[$j + 1];
                }
            }
        }
        return $array;
    }

    /**
     * Selection Sort implementation.
     *
     * @param array $array The array to sort.
     * @return array The sorted array.
     */
    public static function selectionSort(array $array): array
    {
        for ($i = 0; $i < count($array) - 1; $i++) {
            $min_index = $i;
            for ($j = $i + 1; $j < count($array); $j++) {
                if ($array[$j] < $array[$min_index]) {
                    $min_index = $j;
                }
            }
            // Swap the found minimum element with the first element.
            $array[$min_index] ^= $array[$i] ^= $array[$min_index] ^= $array[$i];
        }
        return $array;
    }

    /**
     * Insertion Sort implementation.
     *
     * @param array $array The array to sort.
     * @return array The sorted array.
     */
    public static function insertionSort(array $array): array
    {
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

    /**
     * Merge Sort implementation.
     *
     * @param array $array The array to sort.
     * @return array The sorted array.
     */
    public static function mergeSort(array $array): array
    {
        if (count($array) == 1) return $array;

        $mid = count($array) / 2;
        $left = array_slice($array, 0, $mid);
        $right = array_slice($array, $mid);

        $left = self::mergeSort($left);
        $right = self::mergeSort($right);

        return self::merge($left, $right);
    }

    /**
     * Merge function for Merge Sort.
     *
     * @param array $left The left part of the array.
     * @param array $right The right part of the array.
     * @return array The merged and sorted array.
     */
    private static function merge(array $left, array $right): array
    {
        $result = [];
        while (count($left) > 0 && count($right) > 0) {
            if ($left[0] < $right[0]) {
                $result[] = array_shift($left);
            } else {
                $result[] = array_shift($right);
            }
        }

        while (count($left) > 0) {
            $result[] = array_shift($left);
        }

        while (count($right) > 0) {
            $result[] = array_shift($right);
        }

        return $result;
    }

    /**
     * Quick Sort implementation.
     *
     * @param array $array The array to sort.
     * @param int $low The low index.
     * @param int $high The high index.
     * @return array The sorted array.
     */
    public static function quickSort(array $array, int $low = null, int $high = null): array
    {
        if ($low === null) $low = 0;
        if ($high === null) $high = count($array) - 1;

        if ($low < $high) {
            $pi = self::partition($array, $low, $high);

            self::quickSort($array, $low, $pi - 1);
            self::quickSort($array, $pi + 1, $high);
        }

        return $array;
    }

    /**
     * Partition function for Quick Sort.
     *
     * @param array $array The array to partition.
     * @param int $low The low index.
     * @param int $high The high index.
     * @return int The partition index.
     */
    private static function partition(array &$array, int $low, int $high): int
    {
        $pivot = $array[$high];
        $i = ($low - 1);

        for ($j = $low; $j < $high; $j++) {
            if ($array[$j] < $pivot) {
                $i++;
                $array[$i] ^= $array[$j] ^= $array[$i] ^= $array[$j];
            }
        }

        $array[$i + 1] ^= $array[$high] ^= $array[$i + 1] ^= $array[$high];

        return $i + 1;
    }
}
