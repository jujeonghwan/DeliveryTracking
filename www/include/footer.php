<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

tp_read($_SERVER["DOCUMENT_ROOT"] . "/include/footer.html");


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

$date_from  =   date_difference_day(current_date(), -9);
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