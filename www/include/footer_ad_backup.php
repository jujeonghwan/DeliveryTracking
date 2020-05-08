<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

tp_read($_SERVER["DOCUMENT_ROOT"] . "/include/footer.html");


////////////////////////////////////////////////////////////////////////////////
// 광고 배너 (링크프라이스)

$template = "row_ad_150_60";
tp_dynamic($template);

// 광고배너 갯수 고정 처리
$LINKPRICE_BANNER_COUNT = 0;            // 임시로 막아놓음

$temp_array = array_flip($AD_LINKPRICE_150_60_ARRAY);       // 링크프라이스 (광고)

shuffle($temp_array);                                       // 순서 섞기     

for ($i = 0; $i < $LINKPRICE_BANNER_COUNT; $i++) {
    // 예) http://ad.linkprice.com/stlink.php?m=yes24&a=A100532968&width=150&height=60&target=_blank 
    $ad_linkprice_150_60_link   =   "http://click.linkprice.com/click.php?m=" . $temp_array[$i] . "&l=0000&a=A100532968";
    $ad_linkprice_150_60_text   =   str_cut($AD_LINKPRICE_150_60_ARRAY[$temp_array[$i]], 10);
    $ad_linkprice_150_60_src    =   "http://ad.linkprice.com/stlink.php?m=" . $temp_array[$i] . "&a=A100532968&width=150&height=60&target=_blank";
    
    tp_set($template, array(
        "ad_linkprice_150_60_link"  =>  $ad_linkprice_150_60_link,
        "ad_linkprice_150_60_text"  =>  $ad_linkprice_150_60_text,
        "ad_linkprice_150_60_src"   =>  $ad_linkprice_150_60_src
    ));
    tp_parse($template);    
}



////////////////////////////////////////////////////////////////////////////////
// 하단 광고 배너 (링크프라이스)

$template = "row_ad_footer_150_60";
tp_dynamic($template);

// 광고표시 갯수                           
$LINKPRICE_BANNER_COUNT = 0;            // 임시로 막아놓음

$temp_array = array_flip($AD_LINKPRICE_FOOTER_150_60_ARRAY);                    // 링크프라이스 (광고)

shuffle($temp_array);                                       // 순서 섞기     

for ($i = 0; $i < $LINKPRICE_BANNER_COUNT; $i++) {    
    // 예) http://ad.linkprice.com/stlink.php?m=yes24&a=A100532968&width=150&height=60&target=_blank 
    $ad_linkprice_footer_150_60_link    =   "http://click.linkprice.com/click.php?m=" . $temp_array[$i] . "&l=0000&a=A100532968";
    $ad_linkprice_footer_150_60_text    =   str_cut($AD_LINKPRICE_FOOTER_150_60_ARRAY[$temp_array[$i]], 10);
    $ad_linkprice_footer_150_60_src     =   "http://ad.linkprice.com/stlink.php?m=" . $temp_array[$i] . "&a=A100532968&width=150&height=60&target=_blank";
    
    tp_set($template, array(
        "ad_linkprice_footer_150_60_link"   =>  $ad_linkprice_footer_150_60_link,
        "ad_linkprice_footer_150_60_text"   =>  $ad_linkprice_footer_150_60_text,
        "ad_linkprice_footer_150_60_src"    =>  $ad_linkprice_footer_150_60_src
    ));
    tp_parse($template);    
}



////////////////////////////////////////////////////////////////////////////////
// App 광고 (Android/iOS)

$template = "row_app";
tp_dynamic($template);

$today_date = current_date();           // 오늘 날짜 예) 20161026


// Android/iOS
$BANNER_COL_COUNT_APP = 1;              // 배너 열 표시 갯수(Android/iOS)

foreach ($db_lpa_os_type_array as $key => $val) {

    // 앱더보기 버튼
    $app_type_value     =   $key;
    
    //$app_button_value   =   $db_lpa_button_value_array[$app_type_value];
    // echo "<br />app_button_value : " . $app_button_value;

    $lpa_os_type = $val;                // OS구분

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
    $query .= "where lpa_os_type = '" . $lpa_os_type . "' ";
    $query .= "and lpa_begin_dt <= '" . $today_date . "' ";
    $query .= "and lpa_end_dt >= '" . $today_date . "' ";
    $query .= "order by rand() ";
    $query .= "limit " . $BANNER_COL_COUNT_APP . " ";

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
            "app_type_value"    =>  $app_type_value,

            "app_os"            =>  $app_os,
            "app_link"          =>  $app_link,
            "app_title"         =>  $app_title,
            "app_image"         =>  $app_image,
            "app_desc"          =>  $app_desc
        ));
        tp_parse($template);    
    }
}



////////////////////////////////////////////////////////////////////////////////
// 택배사 배너

$template = "row_delivery";
tp_dynamic($template);

foreach ($COMMON_DELIVERYTYPE_ARRAY as $key => $val) {
    // 택배사 코드
    $delivery_code  =   $val;

    // 배너 명칭
    $delivery_text  =   str_cut($key, 10);

    // 배너 링크
    $delivery_link  =   $COMMON_DELIVERYLINK_ARRAY[$val];
    
    // 배너이미지
    $width  =   150;
    $height =   60;    
    
    $image_name     =   $COMMON_DELIVERYIMAGE_ARRAY[$val];  // 예) doortodoor.gif
    $delivery_img   =   "<img src=\"" . $PATH_VAR["deliveryimage_url"] . "/" . $image_name . "\" alt=\"" . $key . " 배송조회 가기\" width=\"" . $width . "px\" height=\"" . $height . "\" border=\"0\" />";
    
    tp_set($template, array(
        "delivery_code" =>  $delivery_code,
        "delivery_text" =>  $delivery_text,        
        "delivery_link" =>  $delivery_link,
        "delivery_img"  =>  $delivery_img
    ));
    tp_parse($template);    
}



////////////////////////////////////////////////////////////////////////////////
// 일자별 조회 항목수

$template = "row_regtime_count";
tp_dynamic($template);

$date_from  =   date_difference_day(current_date(), -4);
$date_to    =   current_date();

$date_temp  =   $date_from;

//  if ($_REQUEST["dummy"] == "all") {
    
    while ($date_temp <= $date_to) {
        $dt_regtime_date = $date_temp;
        
        // 일자별 사용자ID
        $query = "select dt_ipaddress ";
        $query .= "from deliverytracking_tb ";
        $query .= "where dt_regtime between '" . $date_temp . "000000' and '" . $date_temp . "235959' ";
        $query .= "group by dt_ipaddress ";
        $query .= "order by dt_ipaddress ";
        
        $result_ipaddress = db_query($query);
        
        $dt_ipaddress_count = 0;
        while ($row_ipaddress = db_fetch_array($result_ipaddress)) {
            $dt_ipaddress_count++;
        }
        
        /*
        // 일자별 조회수
        $query = "select count(*) as dt_regtime_count ";
        $query .= "from deliverytracking_tb ";
        $query .= "where dt_regtime between '" . $date_temp . "000000' and '" . $date_temp . "235959' ";
        
        $result_regtime = db_query($query);
        if ($row_regtime = db_fetch_array($result_regtime)) {
            $dt_regtime_count = $row_regtime["dt_regtime_count"];
        }
        else {
            $dt_regtime_count = 0;
        }    
        */    
                 
        // 표시
        tp_set($template, array(
            "dt_regtime_date"       =>  get_day_format($dt_regtime_date),
            "dt_ipaddress_count"    =>  number_format($dt_ipaddress_count)
            // "dt_regtime_count"   =>  number_format($dt_regtime_count)
        ));
        tp_parse($template);
        
        $date_temp = date_difference_day($date_temp, 1);
    }
    
//  }
        
tp_print();

// echo "referer : " . $_SESSION["session_dt_referer"];

?>