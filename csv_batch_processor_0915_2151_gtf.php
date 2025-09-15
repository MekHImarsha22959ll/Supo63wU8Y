<?php
// 代码生成时间: 2025-09-15 21:51:33
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Imports\HeadingRowImport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use App\Models\CsvData; // 假设已经创建了对应的模型

class CsvBatchProcessor
{
    use Importable;

    public function model(array $row)
    {
        // 假设CsvData模型中已经定义了相应的字段
        return new CsvData($row);
    }

    public function batchSize(): int
    {
        // 根据实际情况调整批处理大小
        return 1000;
    }

    public function chunkSize(): int
    {
        // 根据实际情况调整块大小
        return 100;
    }

    public function handle()
    {
        try {
            $path = storage_path('app/public/csv_files');
            $files = scandir($path);
            \$processedCount = 0;
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'csv') {
                    Excel::import(new self(), $path . DIRECTORY_SEPARATOR . $file);
                    \$processedCount++;
                }
            }
            Log::info('Processed ' . \$processedCount . ' CSV files');
        } catch (\Exception \$e) {
            Log::error('Error processing CSV files: ' . \$e->getMessage());
        }
    }
}

// 使用方法
// \$processor = new CsvBatchProcessor();
// \$processor->handle();
