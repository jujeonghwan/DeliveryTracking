<?php

// Wrong:
    fwrite($fp, "GET / HTTP/1.1\r\n");
    fwrite($fp, "Host: php.net\r\n");
    fwrite($fp, "User-Agent: example\r\n\r\n");
    fwrite($fp, "Connection: Close\r\n\r\n");

    // Right:
    fwrite($fp, "GET / HTTP/1.1\r\n" );
    fwrite($fp, "Host: php.net\r\n");
    fwrite($fp, "User-Agent: example\r\n");
    fwrite($fp, "Connection: Close\r\n\r\n");


exit;

$host = 'www.redacted.com';
$data = 'user=redacted&pass=redacted&action=redacted';
$response = "";

if ( $fp = fsockopen("ssl:{$host}", 443, $errno, $errstr, 30) ) {

    $msg  = 'POST /wsAPI.php HTTP/1.1' . "\r\n";
    $msg .= 'Content-Type: application/x-www-form-urlencoded' . "\r\n";
    $msg .= 'Content-Length: ' . strlen($data) . "\r\n";
    $msg .= 'Host: ' . $host . "\r\n";
    $msg .= 'Connection: close' . "\r\n\r\n";
    $msg .= $data;
    if ( fwrite($fp, $msg) ) {
        while ( !feof($fp) ) {
            $response .= fgets($fp, 1024);
        }
    }
    fclose($fp);

} else {
    $response = false;
}

?>