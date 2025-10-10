<?php
// 代码生成时间: 2025-10-10 23:25:58
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

// 数据去重和合并工具类
class DataDeduplicationAndMergeTool extends Model
{
    // 构造函数
    public function __construct()
    {
        // 设置数据库连接
        $this->db = DB::connection();
    }

    // 数据去重函数
    public function deduplicateData($tableName)
    {
        try {
            // 检查表是否存在
            if (!Schema::hasTable($tableName)) {
                throw new Exception('Table does not exist.');
            }

            // 查找重复数据
            $duplicateData = $this->db->table($tableName)
                ->select('column1', 'column2', DB::raw('COUNT(*) as count'))
                ->groupBy('column1', 'column2')
                ->havingRaw('count > 1')
                ->get();

            // 去重数据
            if ($duplicateData->isNotEmpty()) {
                // 删除重复数据
                $duplicateData->each(function ($item) {
                    $firstItemId = $this->db->table($tableName)
                        ->where('column1', $item->column1)
                        ->where('column2', $item->column2)
                        ->first()->id;

                    $this->db->table($tableName)
                        ->where('column1', $item->column1)
                        ->where('column2', $item->column2)
                        ->where('id', '<>', $firstItemId)
                        ->delete();
                });
            }

            return 'Data deduplication completed successfully.';

        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    // 数据合并函数
    public function mergeData($tableName, $mergeColumns)
    {
        try {
            // 检查表是否存在
            if (!Schema::hasTable($tableName)) {
                throw new Exception('Table does not exist.');
            }

            // 查找需要合并的数据
            $mergeData = $this->db->table($tableName)
                ->select($mergeColumns)
                ->get();

            // 合并数据
            $mergedData = [];
            foreach ($mergeData as $item) {
                $key = $item->column1 . '_' . $item->column2;
                if (!isset($mergedData[$key])) {
                    $mergedData[$key] = $item;
                } else {
                    // 合并列数据
                    foreach ($mergeColumns as $column) {
                        if ($column != 'id' && $column != 'column1' && $column != 'column2') {
                            $mergedData[$key]->$column .= ($mergedData[$key]->$column ? ', ' : '') . $item->$column;
                        }
                    }
                }
            }

            // 更新合并后的数据
            foreach ($mergedData as $key => $item) {
                $this->db->table($tableName)
                    ->where('id', $item->id)
                    ->update($item->attributesToArray());
            }

            return 'Data merge completed successfully.';

        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
