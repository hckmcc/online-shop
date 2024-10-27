<?php

namespace Model;

class Logger extends Model
{
    public static function addRecord(string $recordType, string $message, array $data): void
    {
        $stmt = self::getPDO()->prepare("INSERT INTO logs (record_type, message, thrown_message, file, line, datetime) VALUES (:record_type, :message, :thrown_message, :file, :line, :datetime)");
        $stmt->execute(['record_type' => $recordType, 'message' => $message, 'thrown_message' => $data['Message'], 'file' => $data['File'], 'line' => $data['Line'], 'datetime' => $data['Datetime']]);
    }
}