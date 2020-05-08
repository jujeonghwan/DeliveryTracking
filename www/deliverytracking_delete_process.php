<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// user_login_check();
html_meta_charset_utf8();

$dt_id = trim($_REQUEST["dt_id"]);

// 삭제
$query = "delete from deliverytracking_tb ";
$query .= "where dt_id = '" . $dt_id . "' ";
$query .= "limit 1 ";

if ($result = db_query($query)) {
    // alert("삭제되었습니다.");
}
else {
    alert_back("삭제하는데 실패했습니다."); 
}

// 페이지 이동
$location_href = "/?dummy=dummy";
$location_href .= "&deliverytype=" . $_REQUEST["deliverytype"];
// $location_href .= "&keyword=" . urlencode($_REQUEST["keyword"]);
location_href($location_href);

?>