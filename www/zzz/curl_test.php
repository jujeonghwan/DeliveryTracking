<?php

// curl 테스트 (현대택배)

// Initialize a cURL session
$curlsession = curl_init();

////////////////////////////////////////////////////////////////////////////////
// 현대택배 배송조회 1번째 페이지

$curlopt_url        =   "https://www.hlc.co.kr/home/personal/inquiry/track";
$curlopt_postfields =   "InvNo=225100323652&action=processInvoiceSubmit";
// $curlopt_postfields =   "InvNo=225100323652&action=processInvoiceLinkSubmit";
$curlopt_useragent  =   "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)";
$curlopt_referer    =   "https://www.hlc.co.kr/home/personal/inquiry/track";
$curlopt_cookiejar  =   "./cookie.txt";
$curlopt_cookiefile =   "./cookie.txt";

curl_setopt($curlsession, CURLOPT_URL, $curlopt_url);
curl_setopt($curlsession, CURLOPT_HEADER, 1);
curl_setopt($curlsession, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curlsession, CURLOPT_FOLLOWLOCATION, true);                        // 리다이렉트를 자동으로 잡아줘서 302가 아니라 200이 리턴됨
curl_setopt($curlsession, CURLOPT_MAXREDIRS, 10);                               // 최대 리다이렉트 횟수
curl_setopt($curlsession, CURLOPT_POST, 1);
curl_setopt($curlsession, CURLOPT_POSTFIELDS, $curlopt_postfields);
curl_setopt($curlsession, CURLOPT_USERAGENT, $curlopt_useragent);
curl_setopt($curlsession, CURLOPT_REFERER, $curlopt_referer);
curl_setopt($curlsession, CURLOPT_COOKIEJAR, $curlopt_cookiejar);
curl_setopt($curlsession, CURLOPT_COOKIEFILE, $curlopt_cookiefile);
curl_setopt($curlsession, CURLOPT_TIMEOUT, 10);                                 // 타임아웃 시간

$buffer =   curl_exec($curlsession);
$cinfo  =   curl_getinfo($curlsession);
$result =   curl_exec ($curlsession);

// echo "<xmp>" . $result . "</xmp>";
// exit;

// ********** 몇초간 기다려야 데이터 조회 가능함...
sleep(2);

////////////////////////////////////////////////////////////////////////////////
// 현대택배 배송조회 2번째 페이지

$curlopt_url        =   "https://www.hlc.co.kr/home/personal/inquiry/track";
$curlopt_postfields =   "action=processInvoiceLinkSubmit";
// $curlopt_postfields =   "InvNo=225100323652&action=processInvoiceLinkSubmit";
$curlopt_useragent  =   "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)";
$curlopt_referer    =   "https://www.hlc.co.kr/home/personal/inquiry/track";
$curlopt_cookiejar  =   "./cookie.txt";
$curlopt_cookiefile =   "./cookie.txt";

curl_setopt($curlsession, CURLOPT_URL, $curlopt_url);
curl_setopt($curlsession, CURLOPT_HEADER, 1);
curl_setopt($curlsession, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curlsession, CURLOPT_FOLLOWLOCATION, true);                        // 리다이렉트를 자동으로 잡아줘서 302가 아니라 200이 리턴됨
curl_setopt($curlsession, CURLOPT_MAXREDIRS, 10);                               // 최대 리다이렉트 횟수
curl_setopt($curlsession, CURLOPT_POST, 1);
curl_setopt($curlsession, CURLOPT_POSTFIELDS, $curlopt_postfields);
curl_setopt($curlsession, CURLOPT_USERAGENT, $curlopt_useragent);
curl_setopt($curlsession, CURLOPT_REFERER, $curlopt_referer);
curl_setopt($curlsession, CURLOPT_COOKIEJAR, $curlopt_cookiejar);
curl_setopt($curlsession, CURLOPT_COOKIEFILE, $curlopt_cookiefile);
curl_setopt($curlsession, CURLOPT_TIMEOUT, 10);                                 // 타임아웃 시간

$result =   curl_exec ($curlsession);

curl_close($curlsession);

echo "<xmp>" . $result . "</xmp>";
exit;

$data = $result;

?>