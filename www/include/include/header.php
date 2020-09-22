<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/global/global.inc.php");

tp_read($_SERVER["DOCUMENT_ROOT"] . "/include/header.html");

// meta description 태그값
$description = $SITE_VAR["title"];
foreach ($COMMON_DELIVERYTYPE_ARRAY as $key => $val) {
    $description .= ", " . $key . " 배송조회";
}
// echo "<br />" . $description;
tp_set("description", $description);

// 도메인
// tp_set("domain", $SITE_VAR["domain"]);

// 타이틀
tp_set("title", $SITE_VAR["title"]);

// 로고파일
// tp_set("logofile_src", $PATH_VAR["logo_url"] . "/" . $SITE_VAR["logofile"]);

// CSS
tp_set("css_link_list", $css_link_list);

// AddThis Social Sharing Button
/* 예) 
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <div class="addthis_sharing_toolbox">
        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56dd660806a65409"></script>
    </div>
*/
tp_set("addthis_sharing_buttons_script", $ADDTHIS_SHARING_BUTTONS_SCRIPT);

tp_print();

// Google Analytics
require_once ($_SERVER["DOCUMENT_ROOT"] . "/common/google-analytics/analyticstracking.php");

?>