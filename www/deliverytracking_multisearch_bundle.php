<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// user_login_check();
html_meta_charset_utf8();


// $ms_deliverytype =   trim($_REQUEST["deliverytype"]);
// $ms_keyword      =   trim($_REQUEST["keyword"]);
$ms_userid          =   trim($_COOKIE["cookie_dt_userid"]); 
$ms_processstate    =   $db_ms_processstate_array["미처리"];
$ms_regtime         =   current_datetime();

$success_count = 0;
$failure_count = 0;


$ms_keyword = trim($_REQUEST["keyword"]);
$ms_remark = trim($_REQUEST["remark"]);

$keyword_array = array();
$keyword_array = explode("\n", $ms_keyword);
$keyword_array_count = count($keyword_array);

for ($i = 0; $i < $keyword_array_count; $i++) {
    $ms_keyword = trim($keyword_array[$i]);

    foreach ($COMMON_DELIVERYTYPE_ARRAY as $key => $val) {

        $ms_deliverytype = $val;

        // 등록
        $query = "insert into multisearch_tb ( ";
        $query .= "ms_deliverytype, "; 
        $query .= "ms_keyword, ";      
        $query .= "ms_remark, ";      
        $query .= "ms_userid, ";       
        $query .= "ms_processstate, "; 
        $query .= "ms_regtime ";    
        $query .= ") values ( ";
        $query .= "'" . $ms_deliverytype . "', "; 
        $query .= "'" . $ms_keyword . "', ";      
        $query .= "'" . $ms_remark . "', ";      
        $query .= "'" . $ms_userid . "', ";       
        $query .= "'" . $ms_processstate . "', "; 
        $query .= "'" . $ms_regtime . "' ";
        $query .= ")";

        if ($result = db_query($query)) {  
            $success_count++;
        }
        else {
            $failure_count++;
        }
    }
        
}

if ($success_count > 0) {    
    // alert(number_format($success_count) . "항목을 다중검색합니다.");
}
else {
    alert_back("전체택배사 일괄조회하는데 실패했습니다."); 
}

// 페이지 이동
$location_href = "/deliverytracking_multisearch_process.php";
// $location_href .= "&deliverytype=" . $_REQUEST["deliverytype"];
// $location_href .= "&keyword=" . urlencode($_REQUEST["keyword"]);
location_href($location_href);

?>