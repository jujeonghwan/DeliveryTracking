<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// user_login_check();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/header.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/nav.php");

tp_read();


$template = "row";
tp_dynamic($template);

$no = 0;            // NO 초기화

$DATA_ARRAY = array(
    "DATE_TIME_INFO"    =>  "접속날짜시간 정보",
    "HTTP_USER_AGENT"   =>  "웹브라우저 정보",
    "REMOTE_ADDR"       =>  "사용자 IP주소",
    "REMOTE_PORT"       =>  "사용자 Port번호"
);

foreach ($DATA_ARRAY as $key => $val) {
    $no++;

    // tr class (교대로 생상 다르게 표시)
    if (($no % 2) == 0) {
        $tr_class = "success";
    }
    else {
        $tr_class = "warning";
    }

    switch ($key) {
        case "DATE_TIME_INFO":
            $data_title =   $val;
            $data_value =   get_korea_detail_current_datetime();
            break;

        case "HTTP_USER_AGENT":
            $data_title =   $val;
            $data_value =   trim($_SERVER["HTTP_USER_AGENT"]);
            break;

        case "REMOTE_ADDR":
            $data_title =   $val;
            $data_value =   trim($_SERVER["REMOTE_ADDR"]);
            break;

        case "REMOTE_PORT":
            $data_title =   $val;
            $data_value =   trim($_SERVER["REMOTE_PORT"]);
            break;
        
        default:
            $data_title =   "";
            $data_value =   "";
            break;
    }


    tp_set($template, array(
        "tr_class"      =>  $tr_class,
        "no"            =>  $no,
        "data_title"    =>  $data_title,
        "data_value"    =>  $data_value
    ));
    tp_parse($template);
}

tp_print();

require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/footer.php");
// require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/footer_blank.php");

?>