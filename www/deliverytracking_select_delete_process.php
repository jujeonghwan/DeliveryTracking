<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// user_login_check();
html_meta_charset_utf8();


$success_count = 0;
$failure_count = 0;

foreach ($_POST["check_dt_id"] as $key => $val) {
    $dt_id = trim($val);   
    
    // 삭제
    $query = "delete from deliverytracking_tb ";
    $query .= "where dt_id = '" . $dt_id . "' ";
    $query .= "limit 1 ";        
    // echo "<br />" . $query;
    
    if ($result = db_query($query)) {  
        $success_count++;
    }
    else {
        $failure_count++;
    }
}

if ($success_count > 0) {    
    alert(number_format($success_count) . "항목이 삭제되었습니다.");
}
else {
    alert_back("삭제하는데 실패했습니다."); 
}

// 페이지 이동
$location_href = "/?dummy=dummy";
$location_href .= "&search_deliverytype=" . $_REQUEST["search_deliverytype"];
// $location_href .= "&search_keyword=" . urlencode($_REQUEST["search_keyword"]);
location_href($location_href);

?>