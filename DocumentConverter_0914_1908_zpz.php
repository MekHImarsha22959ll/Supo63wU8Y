<?php
// 代码生成时间: 2025-09-14 19:08:20
// DocumentConverter.php

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\Common\XMLWriter;
use PhpOffice\PhpWord\Writer\RTF;
use PhpOffice\PhpWord\Writer\Word2007;
use PhpOffice\PhpWord\Writer\ODText;
use PhpOffice\PhpWord\Writer\PDF\DomPDF;

class DocumentConverter {
    // 将上传的文件转换为目标格式
    public function convert(UploadedFile $file, $outputFormat) {
        // 检查输出格式是否受支持
        if (!in_array($outputFormat, ['pdf', 'docx', 'rtf', 'odt'])) {
            throw new \Exception('Unsupported output format');
        }

        // 保存上传的文件
        $path = $this->saveFile($file);

        // 创建临时文件路径
        $tempPath = $this->createTempFilePath($path, $outputFormat);

        // 读取文档
        $phpWord = IOFactory::load($path);

        // 设置输出格式
        switch ($outputFormat) {
            case 'pdf':
                $writer = new DomPDF($phpWord);
                $writer->save($tempPath);
                break;
            case 'docx':
                $writer = new Word2007($phpWord);
                $writer->save($tempPath);
                break;
            case 'rtf':
                $writer = new RTF($phpWord);
                $writer->save($tempPath);
                break;
            case 'odt':
                $writer = new ODText($phpWord);
                $writer->save($tempPath);
                break;
        }

        // 返回临时文件路径
        return $tempPath;
    }

    // 保存上传的文件
    private function saveFile(UploadedFile $file) {
        $path = 'uploads/' . time() . '_' . $file->getClientOriginalName();
        Storage::put($path, file_get_contents($file->getRealPath()));
        return $path;
    }

    // 创建临时文件路径
    private function createTempFilePath($originalPath, $outputFormat) {
        $extension = '.' . $outputFormat;
        return str_replace('.docx', $extension, $originalPath);
    }
}
