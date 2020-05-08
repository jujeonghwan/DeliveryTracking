<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

tp_read($_SERVER["DOCUMENT_ROOT"] . "/include/footer.html");


////////////////////////////////////////////////////////////////////////////////
// 택배사 배너

$template = "row_delivery";
tp_dynamic($template);

foreach ($COMMON_DELIVERYTYPE_ARRAY as $key => $val) {
    // 배너 명칭
    $delivery_text  =   $key;
    
    // 배너 링크
    $delivery_link  =   $COMMON_DELIVERYLINK_ARRAY[$val];
    
    // 배너이미지
    $width  =   150;
    $height =   60;    
    
    $image_name     =   $COMMON_DELIVERYIMAGE_ARRAY[$val];      // 예) doortodoor.gif
    $delivery_img   =   "<img src=\"" . $PATH_VAR["deliveryimage_url"] . "/" . $image_name . "\" alt=\"" . $key . " 배송조회 가기\" width=\"" . $width . "px\" height=\"" . $height . "\" border=\"0\" />";
    
    tp_set($template, array(
        "delivery_text" =>  $delivery_text,
        "delivery_link" =>  $delivery_link,
        "delivery_img"  =>  $delivery_img
    ));
    tp_parse($template);    
}


////////////////////////////////////////////////////////////////////////////////
// 광고 배너 (링크프라이스)

$template = "row_ad_150_60";
tp_dynamic($template);

$BANNER_COL_COUNT = 6;                  // 배너 열 표시 갯수

// 택배사 배너 + 택배사 제목 (택배사 배송조회 가기)
$prev_banner_count = count($COMMON_DELIVERYTYPE_ARRAY) + 1;

// 광고표시 갯수                           
$LINKPRICE_BANNER_COUNT = 1;            // 1개로 초기화
while ( ($prev_banner_count + $LINKPRICE_BANNER_COUNT) % $BANNER_COL_COUNT != 0) {                  // 총 배너갯수를 '배너 열 표시 갯수'로 나눠지도록 맞춤
    $LINKPRICE_BANNER_COUNT++;
}

$temp_array = array_flip($AD_LINKPRICE_150_60_ARRAY);       // 링크프라이스 (광고)

shuffle($temp_array);                                       // 순서 섞기     

for ($i = 0; $i < $LINKPRICE_BANNER_COUNT; $i++) {    
    // 예) http://ad.linkprice.com/stlink.php?m=yes24&a=A100532968&width=150&height=60&target=_blank 
    $ad_linkprice_150_60_text   =    str_cut($AD_LINKPRICE_150_60_ARRAY[$temp_array[$i]], 10);
    $ad_linkprice_150_60_src    =   "http://ad.linkprice.com/stlink.php?m=" . $temp_array[$i] . "&a=A100532968&width=150&height=60&target=_blank";
    
    tp_set($template, array(
        "ad_linkprice_150_60_text"  =>  $ad_linkprice_150_60_text,
        "ad_linkprice_150_60_src"   =>  $ad_linkprice_150_60_src
    ));
    tp_parse($template);    
}

tp_print();

// echo "referer : " . $_SESSION["session_dt_referer"];

?>