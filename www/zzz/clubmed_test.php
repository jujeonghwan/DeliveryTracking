<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/header.php");
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/nav.php");

// tp_read($_SERVER["DOCUMENT_ROOT"] . "/main.html");

$cp_resort = "Bali";

// 리조트별 가격을 구함
get_clubmed_price_result($cp_resort);


require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/footer.php");

?>