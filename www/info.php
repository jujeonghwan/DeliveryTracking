<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// user_login_check();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/header.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/nav.php");

tp_read();


// 구분
$infotype = trim($_REQUEST["infotype"]);
if ($infotype == "") {
    $infotype = $INFO_TYPE_ARRAY["웹사이트(Web Site)"];
}
/*
$option_array = array_flip($INFO_TYPE_ARRAY);
$option = get_select_option("--전체--", $option_array, $infotype);
tp_set("option_infotype", $option);
*/
// radio(옵션) 박스
$radio_array = array_flip($INFO_TYPE_ARRAY);
$radio = get_input_radio("infotype", $radio_array, $infotype, "");
tp_set("radio_infotype", $radio);



////////////////////////////////////////////////////////////////////////////////
// 웹사이트(Web Site) : 광고 배너 (링크프라이스)

$template = "row_ad_150_60";
tp_dynamic($template);

if ($infotype == $INFO_TYPE_ARRAY["웹사이트(Web Site)"]) {
    // 광고배너 갯수 고정 처리
    // $LINKPRICE_BANNER_COUNT = 30;
    $LINKPRICE_BANNER_COUNT = count($AD_LINKPRICE_150_60_ARRAY);

    $temp_array = array_flip($AD_LINKPRICE_150_60_ARRAY);   // 링크프라이스 (광고)

    /*
    shuffle($temp_array);                                   // 순서 섞기
    */

    $i = 0;

    foreach ($temp_array as $key => $val) {
        $i++;

        if ($i > $LINKPRICE_BANNER_COUNT) {
            break;
        }

        // 예) http://ad.linkprice.com/stlink.php?m=yes24&a=A100532968&width=150&height=60&target=_blank 
        $ad_linkprice_150_60_link   =   "http://click.linkprice.com/click.php?m=" . $temp_array[$key] . "&l=0000&a=A100532968";
        $ad_linkprice_150_60_text   =   str_cut($AD_LINKPRICE_150_60_ARRAY[$temp_array[$key]], 10);
        $ad_linkprice_150_60_src    =   "http://ad.linkprice.com/stlink.php?m=" . $temp_array[$key] . "&a=A100532968&width=150&height=60&target=_blank";
        
        tp_set($template, array(
            "ad_linkprice_150_60_link"  =>  $ad_linkprice_150_60_link,
            "ad_linkprice_150_60_text"  =>  $ad_linkprice_150_60_text,
            "ad_linkprice_150_60_src"   =>  $ad_linkprice_150_60_src
        ));
        tp_parse($template);
    }
}



////////////////////////////////////////////////////////////////////////////////
// 아이폰앱(iOS App) : App 광고 (Android/iOS)

$template = "row_app_ios";
tp_dynamic($template);

$today_date = current_date();           // 오늘 날짜 예) 20161026

if ($infotype == $INFO_TYPE_ARRAY["아이폰앱(iOS App)"]) {
    // 링크프라이스앱광고
    $query = "select ";
    $query .= "lpa_app_id, ";
    $query .= "lpa_merchant_id, ";
    $query .= "lpa_ad_name, ";
    $query .= "lpa_os_type, ";
    $query .= "lpa_banner_url, ";
    $query .= "lpa_price, ";
    $query .= "lpa_begin_dt, ";
    $query .= "lpa_end_dt, ";
    $query .= "lpa_daily_cap, ";
    $query .= "lpa_click_url, ";
    $query .= "lpa_ad_desc ";
    $query .= "from linkpriceapp_tb ";
    $query .= "where lpa_os_type = '" . $db_lpa_os_type_array["iOS"] . "' ";
    $query .= "and lpa_begin_dt <= '" . $today_date . "' ";
    $query .= "and lpa_end_dt >= '" . $today_date . "' ";
    $query .= "order by rand() ";
    $query .= "limit 9 ";

    $result_lpa = db_query($query);

    while ($row_lpa = db_fetch_array($result_lpa)) {
        // 배너이미지 크기
        $width  =   150;
        $height =   150;   

        $app_os     =   array_search($row_lpa["lpa_os_type"], $db_lpa_os_type_array) . " App";
        $app_link   =   $row_lpa["lpa_click_url"];
        $app_title  =   str_cut($row_lpa["lpa_ad_name"], 24);
        $app_image  =   "<img src=\"" . $row_lpa["lpa_banner_url"] . "\" alt=\"" . $row_lpa["lpa_ad_name"] . "\" width=\"" . $width . "px\" height=\"" . $height . "\" border=\"0\" />";
        $app_desc   =   str_cut($row_lpa["lpa_ad_desc"], 24);
        
        tp_set($template, array(
            "app_os"    =>  $app_os,
            "app_link"  =>  $app_link,
            "app_title" =>  $app_title,
            "app_image" =>  $app_image,
            "app_desc"  =>  $app_desc
        ));
        tp_parse($template);    
    }
}



////////////////////////////////////////////////////////////////////////////////
// 안드로이드앱(Android App) : App 광고 (Android/iOS)

$template = "row_app_android";
tp_dynamic($template);

$today_date = current_date();           // 오늘 날짜 예) 20161026

if ($infotype == $INFO_TYPE_ARRAY["안드로이드앱(Android App)"]) {
    // 링크프라이스앱광고
    $query = "select ";
    $query .= "lpa_app_id, ";
    $query .= "lpa_merchant_id, ";
    $query .= "lpa_ad_name, ";
    $query .= "lpa_os_type, ";
    $query .= "lpa_banner_url, ";
    $query .= "lpa_price, ";
    $query .= "lpa_begin_dt, ";
    $query .= "lpa_end_dt, ";
    $query .= "lpa_daily_cap, ";
    $query .= "lpa_click_url, ";
    $query .= "lpa_ad_desc ";
    $query .= "from linkpriceapp_tb ";
    $query .= "where lpa_os_type = '" . $db_lpa_os_type_array["Android"] . "' ";
    $query .= "and lpa_begin_dt <= '" . $today_date . "' ";
    $query .= "and lpa_end_dt >= '" . $today_date . "' ";
    $query .= "order by rand() ";
    $query .= "limit 9 ";

    $result_lpa = db_query($query);

    while ($row_lpa = db_fetch_array($result_lpa)) {
        // 배너이미지 크기
        $width  =   150;
        $height =   150;   

        $app_os     =   array_search($row_lpa["lpa_os_type"], $db_lpa_os_type_array) . " App";
        $app_link   =   $row_lpa["lpa_click_url"];
        $app_title  =   str_cut($row_lpa["lpa_ad_name"], 24);
        $app_image  =   "<img src=\"" . $row_lpa["lpa_banner_url"] . "\" alt=\"" . $row_lpa["lpa_ad_name"] . "\" width=\"" . $width . "px\" height=\"" . $height . "\" border=\"0\" />";
        $app_desc   =   str_cut($row_lpa["lpa_ad_desc"], 24);
        
        tp_set($template, array(
            "app_os"    =>  $app_os,
            "app_link"  =>  $app_link,
            "app_title" =>  $app_title,
            "app_image" =>  $app_image,
            "app_desc"  =>  $app_desc
        ));
        tp_parse($template);    
    }
}

tp_print();

// require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/footer.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/footer_blank.php");

?>