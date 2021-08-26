<?php

use Carbon\Carbon;

if (!function_exists('logFile')) {
    function logFile($ip, $jenis, $userId, $data)
    {
        $logName = 'kampaser';
        $uniqId = 'PRODUCTION.' . $jenis;
        $ext = ".log";
        $ipAddress = ip2long($ip);

        $fileName = storage_path() . '/' . 'logs/' . $logName . '-' . Carbon::now()->format('Y-m-d') . $ext;
        $text = Carbon::now() . "\t" . $ipAddress . "\t" . $userId . "\t" . $uniqId . "\t" . json_encode($data);

        $mode = (file_exists($fileName) ? 'a' : 'w');
        $handle = fopen($fileName, $mode);

        fwrite($handle, $text . "\n");
        fclose($handle);
    }
}
