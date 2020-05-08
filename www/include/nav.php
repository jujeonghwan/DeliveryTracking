<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

tp_read($_SERVER["DOCUMENT_ROOT"] . "/include/nav.html");

tp_set("home_url", $SITE_VAR["url"]);
tp_set("logofile_src", $PATH_VAR["logo_url"] . "/" . $SITE_VAR["logofile"]);
tp_set("title", $SITE_VAR["title"]);
tp_set("logotitle", $SITE_VAR["logotitle"]);


////////////////////////////////////////////////////////////////////////////////
// 광고 배너 (링크프라이스)

$template = "row_ad_header_150_60";
tp_dynamic($template);

// 광고표시 갯수                           
$LINKPRICE_BANNER_COUNT = 0;

$temp_array = array_flip($AD_LINKPRICE_HEADER_150_60_ARRAY);                    // 링크프라이스 (광고)

shuffle($temp_array);                                       // 순서 섞기     

for ($i = 0; $i < $LINKPRICE_BANNER_COUNT; $i++) {    
    // 예) http://ad.linkprice.com/stlink.php?m=yes24&a=A100532968&width=150&height=60&target=_blank 
    $ad_linkprice_header_150_60_link    =   "http://click.linkprice.com/click.php?m=" . $temp_array[$i] . "&l=0000&a=A100532968";
    $ad_linkprice_header_150_60_text    =   str_cut($AD_LINKPRICE_HEADER_150_60_ARRAY[$temp_array[$i]], 10);
    $ad_linkprice_header_150_60_src     =   "http://ad.linkprice.com/stlink.php?m=" . $temp_array[$i] . "&a=A100532968&width=150&height=60&target=_blank";
    
    tp_set($template, array(
        "ad_linkprice_header_150_60_link"   =>  $ad_linkprice_header_150_60_link,
        "ad_linkprice_header_150_60_text"   =>  $ad_linkprice_header_150_60_text,
        "ad_linkprice_header_150_60_src"    =>  $ad_linkprice_header_150_60_src
    ));
    tp_parse($template);    
}

// 공지사항 출력

// 현재 일시를 구함
$current_date_time = current_datetime();
// echo $current_date_time;

if (($current_date_time >= "20190519000000") && ($current_date_time <= "20190519110000")) {
    
    $notice_text = "
        <pre>
            CJ대한통운 택배정보시스템 정기점검 작업 안내
            
            CJ대한통운 택배 홈페이지를 이용해주시는 고객님께 감사드립니다.
            아래의 일정으로 CJ대한통운 택배정보시스템의 정기점검 및 DB성능 개선작업을 실시합니다.
            
            일시 : 5월 19일(일요일) 00시 ~ 11시
            
            정기점검 동안 배송조회 등 홈페이지와 택배 앱을 이용한 서비스가 일시 중단되오니 이용에 참고하시기 바랍니다. 감사합니다.
        </pre>
    ";
    
}

tp_set("notice_text", $notice_text);

tp_print();

?>