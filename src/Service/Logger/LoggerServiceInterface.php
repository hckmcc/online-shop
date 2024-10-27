<?php

namespace Service\Logger;

interface LoggerServiceInterface
{
    public function addErrorToLog(string $message, array $data = []): void;
    public function addInfoToLog(string $message, array $data = []): void;
    public function addWarningToLog(string $message, array $data = []): void;
}