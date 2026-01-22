<?php

namespace App\Logger;

class Logger implements LoggerInterface
{
    private string $file;

    public function __construct(string $file = __DIR__ . '/../../logs/app.log')
    {
        $this->file = $file;
    }

    public function info(string $message): void
    {
        $this->writeLog('INFO', $message);
    }

    public function warning(string $message): void
    {
        $this->writeLog('WARNING', $message);
    }

    private function writeLog(string $level, string $message): void
    {
        $date = date('Y-m-d H:i:s');
        $line = "[$date] [$level] $message\n";
        file_put_contents($this->file, $line, FILE_APPEND);
    }
}

// JSON для теста логгера:
//{
//    "uuid": "99999999-9999-9999-9999-999999999999",
//  "user_name": "logtestuser",
//  "first_name": "Log",
//  "last_name": "Tester"
//}