<?php


    $request_protocol = "http";
    $request_host = "www.hdexp.co.kr";
    
    $string = "";
    $string .= "GET http://www.hdexp.co.kr/deliverySearch.hd?company_gubun=H&search_month=201604&barcode=209016103305 HTTP/1.0\r\n";
    $string .= "Accept: application/json, text/javascript, */*; q=0.01\r\n";
    $string .= "X-Requested-With: XMLHttpRequest\r\n";
    $string .= "Referer: http://www.hdexp.co.kr/delivery_search.hd\r\n";
    $string .= "Accept-Language: ko\r\n";
    $string .= "Accept-Encoding: gzip, deflate\r\n";
    $string .= "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko\r\n";
    $string .= "Host: www.hdexp.co.kr\r\n";
    // $string .= "Connection: Keep-Alive\r\n";
    $string .= "Cookie: JSESSIONID=2FA31628186275FC48DA399AC18D1364\r\n";
    $string .= "Connection: Close\r\n\r\n";

    
    
    
    if ($request_protocol == "https") {
        $fsockopen_hostname =   "ssl://" . $request_host;
        $fsockopen_port     =   443;    
    }
    else {
        $fsockopen_hostname =   $request_host;
        $fsockopen_port     =   80;
    }
    
    $fp = fsockopen($fsockopen_hostname, $fsockopen_port);
    fputs($fp, $string);
    
    $data = "";
    while (!feof($fp)) {
        $data .= fgets($fp, 1024);   
    }
    fclose($fp);
    
    // echo $data; exit;
    echo "<xmp>" . $data . "</xmp>"; exit;
    /*
    if ($request_host == "www.hlc.co.kr") {              // 현대택배
        echo "<xmp>" . $data . "</xmp>"; exit;
    }
    */


?>