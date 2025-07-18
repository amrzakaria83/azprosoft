<?php
$host = '41.33.4.126';
$port = 1433;
$timeout = 5;

$socket = @fsockopen($host, $port, $errno, $errstr, $timeout);
if ($socket) {
    echo "Port $port is open!";
    fclose($socket);
} else {
    echo "Port $port is closed or blocked. Error: $errstr";
}