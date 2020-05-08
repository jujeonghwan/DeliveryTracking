<?php

exit;

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

// user_login_check();
html_meta_charset_utf8();

// 택배사
$deliverytype = trim($_REQUEST["deliverytype"]);
if ($deliverytype == "") {
    $deliverytype = $COMMON_DELIVERYTYPE_ARRAY["CJ대한통운"];
}

// 검색어
$keyword = trim($_REQUEST["keyword"]);

echo "<br />================================================================================";
echo "<br />택배사 자동검색 진행중...";

echo "<br /><br />택배사 : " . array_search($deliverytype, $COMMON_DELIVERYTYPE_ARRAY);
echo "<br /><br />검색어 : " . $keyword;
echo "<br /><br />";




exit;

// 페이지 이동
$location_href = "/?dummy=dummy";
$location_href .= "&search_deliverytype=" . $_REQUEST["search_deliverytype"];
// $location_href .= "&search_keyword=" . urlencode($_REQUEST["search_keyword"]);
location_href($location_href);

?>