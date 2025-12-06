<?php


function logError($message) {
    $date = date('Y-m-d H:i:s');
    $logFile = __DIR__ . '/../logs/app.log';
    file_put_contents($logFile, "[$date] $message\n", FILE_APPEND);
}

