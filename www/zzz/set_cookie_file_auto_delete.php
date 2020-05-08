<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

html_meta_charset_utf8();

exit;

// 쿠키파일 정리
set_cookie_file_auto_delete();

// 택배사배송조회 수집파일 정리
set_deliverytracking_file_auto_delete();

?>