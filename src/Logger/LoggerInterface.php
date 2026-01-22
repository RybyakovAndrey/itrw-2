<?php

namespace App\Logger;

interface LoggerInterface
{
    public function info(string $message): void;
    public function warning(string $message): void;
}
