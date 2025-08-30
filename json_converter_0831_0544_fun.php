<?php
// 代码生成时间: 2025-08-31 05:44:44
class JsonConverter {

    /**
     * 将数组或对象转换为JSON字符串
     *
     * @param mixed $data 要转换的数据
     * @return string JSON字符串
     * @throws InvalidArgumentException 如果输入的数据类型不支持
     */
    public function convertToJson($data): string {
        // 检查输入数据是否为空
        if (empty($data)) {
            throw new InvalidArgumentException('输入数据不能为空');
        }

        // 尝试将数据转换为JSON字符串
        $json = json_encode($data);

        // 检查转换是否成功
        if ($json === false) {
            // 获取最后一次错误的信息
            $error = json_last_error_msg();
            throw new InvalidArgumentException('JSON编码失败: ' . $error);
        }

        // 返回JSON字符串
        return $json;
    }

    /**
     * 将JSON字符串转换为数组或对象
     *
     * @param string $json JSON字符串
     * @param bool $assoc 是否将结果转换为关联数组
     * @return mixed 数组或对象
     * @throws InvalidArgumentException 如果输入的JSON字符串无效
     */
    public function convertFromJson(string $json, bool $assoc = true) {
        // 检查输入的JSON字符串是否为空
        if (empty($json)) {
            throw new InvalidArgumentException('输入的JSON字符串不能为空');
        }

        // 尝试将JSON字符串解析为PHP变量
        $data = json_decode($json, $assoc);

        // 检查解析是否成功
        if (json_last_error() !== JSON_ERROR_NONE) {
            // 获取最后一次错误的信息
            $error = json_last_error_msg();
            throw new InvalidArgumentException('JSON解析失败: ' . $error);
        }

        // 返回解析后的数据
        return $data;
    }
}
