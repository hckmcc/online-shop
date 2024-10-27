<?php

namespace Service\Logger;

class LoggerFileService implements LoggerServiceInterface
{
    public function addErrorToLog(string $message, array $data=[]):void
    {
        $file = "../Storage/Log/errors.txt";
        file_put_contents($file, "$message\n", FILE_APPEND);
        $data = $this->appendDatetime($data);
        foreach ($data as $key => $value) {
            file_put_contents($file, "$key: $value\n", FILE_APPEND);
        }
    }

    public function addInfoToLog(string $message, array $data=[]):void
    {
        $file = "../Storage/Log/info.txt";
        file_put_contents($file, "$message\n", FILE_APPEND);
        $data = $this->appendDatetime($data);
        foreach ($data as $key => $value) {
            file_put_contents($file, "$key: $value\n", FILE_APPEND);
        }
    }

    public function addWarningToLog(string $message, array $data=[]):void
    {
        $file = "../Storage/Log/warnings.txt";
        file_put_contents($file, "$message\n", FILE_APPEND);
        $data = $this->appendDatetime($data);
        foreach ($data as $key => $value) {
            file_put_contents($file, "$key: $value\n", FILE_APPEND);
        }
    }
    private function appendDatetime(array $data): array
    {
        date_default_timezone_set('Europe/Moscow');
        $date = date('Y-m-d H:i:s');
        $data["Datetime"]="$date \n";
        return $data;
    }
}