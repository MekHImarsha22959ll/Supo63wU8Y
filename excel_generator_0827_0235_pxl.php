<?php
// 代码生成时间: 2025-08-27 02:35:24
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Excel表格自动生成器
 *
 * 使用Laravel框架和PhpSpreadsheet库创建一个简单的Excel文件生成器
 *
 * @author Your Name
 * @date 2023-04-01
 */
class ExcelGenerator {

    /**
     * 生成Excel文件并保存到指定路径
     *
     * @param array $data 要写入Excel的数据
     * @param string $filePath 文件保存路径
     * @param string $sheetName 工作表名称
     * @return bool
     */
    public function generateExcel(array $data, string $filePath, string $sheetName = 'Sheet1'): bool {
        try {
            // 创建一个新的spreadsheet对象
            $spreadsheet = new Spreadsheet();

            // 激活第一个工作表
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle($sheetName);

            // 写入数据到工作表
            $row = 1; // 起始行号
            foreach ($data as $key => $value) {
                $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key) . $row;
                $sheet->setCellValue($cell, $value);
            }

            // 设置header信息
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename=