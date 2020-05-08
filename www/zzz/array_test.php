<?php

// 택배사구분 (알파벳순)
$COMMON_DELIVERYTYPE_ARRAY = array (
    "쿠팡로켓배송" => "coupang",
    "대운글로벌(국제)" => "daewoonsys",
    "DHL(국제)" => "dhl",
    "CJ대한통운" => "doortodoor",
    "CJ대한통운NPlus" => "doortodoornplus",
    "대신택배" => "ds3211",
    "EMS국제우편(국제)" => "ems",
    "우체국택배" => "epost",
    "FedEx(국제)" => "fedex",
    "GTX로지스" => "gtxlogis",
    "한진택배" => "hanjin",
    "합동택배" => "hdexp",
    "현대택배" => "hlc",
    "현대로지스틱스국제특송(국제)" => "hyundaiexp",
    "로젠택배" => "ilogen",    
    "일양로지스" => "ilyanglogis",    
    "KGB택배" => "kgbls",
    "KG로지스" => "kglogis",
    "대한통운국제특송(해외->한국)" => "korexinbound",
    // "대한통운국제특송(한국->해외)" => "korexoutbound",
    "TNT(국제)" => "tnt",
    "UPS(국제)" => "ups", 
    "YANWEN(국제)" => "yw56"
);


// 정렬해서사용
// arsort($COMMON_DELIVERYTYPE_ARRAY);
asort($COMMON_DELIVERYTYPE_ARRAY);

print_r($COMMON_DELIVERYTYPE_ARRAY);

?>