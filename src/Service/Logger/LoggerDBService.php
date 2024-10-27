<?php

namespace Service\Logger;

use Model\Logger;

class LoggerDBService implements LoggerServiceInterface
{
    public function addErrorToLog(string $message, array $data = []): void
    {
        Logger::addRecord("Error", $message, $this->appendDatetime($data));
    }
    public function addInfoToLog(string $message, array $data = []): void
    {
        Logger::addRecord("Info", $message, $this->appendDatetime($data));
    }
    public function addWarningToLog(string $message, array $data = []): void
    {
        Logger::addRecord("Warning", $message, $this->appendDatetime($data));
    }
    private function appendDatetime(array $data): array
    {
        date_default_timezone_set('Europe/Moscow');
        $data["Datetime"]=date('Y-m-d H:i:s');
        return $data;
    }
}