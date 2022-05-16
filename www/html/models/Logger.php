<?php


class Logger
{
    private static $_instance = null;

    const INFO_LEVEL = '== info ==';
    const WARNING_LEVEL = '== warning ==';
    const ERROR_LEVEL = '== error ==';

    public static function Write($message, $level = Logger::INFO_LEVEL) {
        $logDir = dirname(Config::get('logFile'));
        $fileName = basename(Config::get('logFile'), '.log');

        if (!is_dir($logDir) && !mkdir($logDir, 0777, true)) {
            die('Не удалось создать директории для Логгера...'.PHP_EOL);
        }

        $logFile = Config::get('logFile');
        if (filesize($logFile) > 1000000) {
            rename($logFile, $logDir . '/'.$fileName.'-'.date('Y-m-d').'.log');
        }
        $logString = date('Y-m-d H:i:s').' '.$level.' '.$message.PHP_EOL;

        file_put_contents($logFile, $logString, FILE_APPEND);
    }
}