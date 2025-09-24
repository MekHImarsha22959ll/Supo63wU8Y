<?php
// 代码生成时间: 2025-09-24 12:20:09
class ProcessManager {

    /**
     * List all system processes.
     *
     * @return array
     */
    public function listProcesses() {
        try {
            $processes = shell_exec('ps aux');
            $processLines = explode("
", $processes);
            $processList = [];
            foreach ($processLines as $line) {
                if ($line) {
                    $processList[] = $line;
                }
            }
            return $processList;
        } catch (Exception $e) {
            // Handle exception and return error message
            return ['error' => 'Failed to list processes: ' . $e->getMessage()];
        }
    }

    /**
     * Kill a specific process by its PID.
     *
     * @param int $pid Process ID
     * @return bool
     */
    public function killProcess($pid) {
        try {
            if (!is_numeric($pid)) {
                return false;
            }
            $result = shell_exec("kill -9 $pid");
            return $result === ""; // Empty result indicates success
        } catch (Exception $e) {
            // Handle exception and return error message
            return false;
        }
    }

    /**
     * Get process details by its PID.
     *
     * @param int $pid Process ID
     * @return array
     */
    public function getProcessDetails($pid) {
        try {
            if (!is_numeric($pid)) {
                return ['error' => 'Invalid process ID'];
            }
            $processDetails = shell_exec("ps -p $pid -o pid,user,%cpu,%mem,command");
            return explode("
", $processDetails);
        } catch (Exception $e) {
            // Handle exception and return error message
            return ['error' => 'Failed to get process details: ' . $e->getMessage()];
        }
    }
}
