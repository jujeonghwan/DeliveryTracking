<?php

$ch = curl_init("https://hdexp.co.kr/deliverySearch2.hd?barcode=3132062290287");
// $fp = fopen("test.txt", "w");

// curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

$result = curl_exec($ch);

echo "<xmp>" . $result . "</xmp>";

curl_close($ch);
// fclose($fp);


// GET https://hdexp.co.kr/deliverySearch2.hd?barcode=3132062290287 HTTP/1.1
// Host: hdexp.co.kr
// Connection: keep-alive
// Cache-Control: max-age=0
// Upgrade-Insecure-Requests: 1
// User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.// 3729.169 Safari/537.36
// Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/// signed-exchange;v=b3
// Accept-Encoding: gzip, deflate, br
// Accept-Language: en-US,en;q=0.9,ko;q=0.8,la;q=0.7
// Cookie: JSESSIONID=847D203E01E70C7A164BD419A4ADB373


