<?php

namespace Service;

class LoggerService
{
    public static function addErrorToLog($exception):void
    {
        date_default_timezone_set('Europe/Moscow');
        $errorData = ["Message:"=>$exception->getMessage(), "File:"=>$exception->getFile(), "Line:"=>$exception->getLine(), "Datetime:"=>date("Y-m-d H:i:s"), " "=>"\n"];
        foreach ($errorData as $key => $value) {
            file_put_contents("../Storage/Log/errors.txt", "$key $value\n", FILE_APPEND);
        }
    }
}